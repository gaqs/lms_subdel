<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\BlogModel;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class User extends ShieldLogin
{
    protected $userRules;
    protected $courseModel;
    protected $blogModel;
    
    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->blogModel = new blogModel();

        $this->userRules = Services::validation();
    }

    public function index()
    {
        $users = auth()->getProvider();
        $data['user'] = $users->findById( auth()->user()->id );

        return view('shield/sections/profile', $data);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $users = auth()->getProvider();

        if(!$this->userRules->run($request, 'user_rules')){ 
            return redirect()->back()->withInput()->with('errors', $this->userRules->getErrors());
        }

        $user = $users->findById( auth()->user()->id );

        $user->fill([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'sex' => $request['sex'],
            'phone' => $request['phone'],
            'birthday' => $request['birthday']
        ]);

        $users->save($user);

        return redirect()->back()->withInput()->with('success', 'Perfil actualizado correctamente');

    }
    public function courses()
    {
        $data['courses'] = $this->courseModel->select('courses.*, users.name, users.lastname, (SELECT lessons.id FROM lessons WHERE lessons.course_id = courses.id ORDER BY id LIMIT 1) AS first')
                                             ->join('users', 'users.id = courses.instructor_id')
                                             ->join('user_has_courses', 'user_has_courses.course_id = courses.id')
                                             ->where('user_has_courses.user_id', auth()->user()->id )
                                             ->asObject()
                                             ->findAll();

        return view('shield/sections/courses', $data);
    }

    public function password()
    {
        return view('shield/sections/password');
    }

    public function change_password()
    {
        $users = auth()->getProvider();

        $request = $this->request->getPost();

        $user = $users->findById( auth()->user()->id );

        $credentials = [
            'email' => auth()->user()->email,
            'password' => $request['oldpass'],
        ];
        $validate = auth()->check( $credentials );

        if( !$this->userRules->run($request, 'password') ){
            return redirect()->back()->withInput()->with('errors', $this->userRules->getErrors());
        }elseif( !$validate->isOK() ){
            return redirect()->back()->withInput()->with('error', 'contraseña no corresponde a la cuenta' );
        } 

        $user->fill([
            'password' => $request['newpass'],
        ]);  

        $users->save($user);
        
        return redirect()->back()->withInput()->with('success', 'Contraseña cambiada correctamente');
    }

    public function wishlist()
    {
        $data['courses'] = $this->courseModel->select('courses.*, users.name, users.lastname')
                                             ->join('users', 'users.id = courses.instructor_id')
                                             ->join('user_has_wishes', 'user_has_wishes.course_id = courses.id')
                                             ->where('user_has_wishes.user_id', auth()->user()->id )
                                             ->asObject()
                                             ->findAll();

        $data['posts'] = $this->blogModel->select('blogs.*, users.name, users.lastname')
                                             ->join('users', 'users.id = blogs.user_id')
                                             ->join('user_has_wishes', 'user_has_wishes.blog_id = blogs.id')
                                             ->where('user_has_wishes.user_id', auth()->user()->id )
                                             ->asObject()
                                             ->findAll();

        return view('shield/sections/wishlist', $data);
    }
    public function user_save_wish()
    {
        $course_id = $this->request->getGet('course_id');
        // ó
        $post_id = $this->request->getGet('post_id');

        $db = db_connect();
        $builder = $db->table('user_has_wishes');

        if( !empty($course_id) ){
            $id_type = 'course_id';
            $id_value = $course_id;
        }elseif( !empty($post_id) ){
            $id_type = 'blog_id';
            $id_value = $post_id;
        }else{
            return redirect()->back()->withInput()->with('error', 'No se proporcionó un ID válido');
        }

        $user_has_wishes = $builder->where($id_type, $id_value)
                                    ->where('user_id', auth()->user()->id)
                                    ->get()->getRowObject();
        //dd($user_has_wishes);
        if( !empty($user_has_wishes)){
            //eliminar
            $builder->delete(['id' => $user_has_wishes->id]);

            return redirect()->back();
        }else{
            //inscribir al curso
           $data = [
            $id_type => $id_value,
            'user_id'   => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s')
           ];

           $builder->insert($data);

           return redirect()->back()->withInput()->with('success', 'Curso guardado correctamente');
        }
        
    }
}
