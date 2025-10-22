<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\CourseModel;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use App\Models\CommentModel;

use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;

class Course extends BaseController
{
    protected $categoryModel;
    protected $moduleModel;
    protected $courseModel;
    protected $lessonModel;
    protected $commentModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->courseModel   = new CourseModel();
        $this->lessonModel   = new LessonModel();
        $this->moduleModel   = new ModuleModel();
        $this->commentModel  = new CommentModel();
    }
    
    public function index()
    {
        $categories = $this->request->getGET('cat');

        $builder = $this->courseModel->select('courses.*, users.name, users.lastname, categories.name as category_name, categories.color, (SELECT COUNT(id) FROM lessons WHERE lessons.course_id = courses.id) as lesson_qty')
                                    ->join('users', 'users.id = courses.instructor_id')
                                    ->join('categories', 'categories.id = courses.category_id')
                                    ->where('courses.status', 'publish')
                                    ->orderBy('users.id', 'DESC')
                                    ->asObject();

        if( empty($categories) || in_array(0,$categories) || $categories == null ){
            $builder = $builder->paginate(6, 'res');
        }else{
            $builder = $builder->whereIn('category_id', $categories)
                                ->paginate(6, 'res');
        }

        $cat = $this->categoryModel->asObject()->findAll();
        $data = [
            'courses' => $builder,
            'pager' => $this->courseModel->pager,
            'cat' => $cat
        ];
        return view('web/sections/course/home', $data);
    }

    public function show($id)
    {
        $course = $this->courseModel->select('courses.*, levels.level as level, categories.name as category_name, users.name as username, users.id as userid, users.lastname as userlastname, auth_identities.secret as useremail')
                                    ->join('categories', 'courses.category_id = categories.id')
                                    ->join('levels', 'courses.level_id = levels.id')
                                    ->join('users', 'courses.instructor_id = users.id')
                                    ->join('auth_identities', 'courses.instructor_id = auth_identities.user_id')
                                    ->asObject()->find($id);
        
        $db = db_connect();
        $builder = $db->table('user_has_wishes');
        
        $data['has_wish'] = '';
        if( isset( auth()->user()->id )){
            $data['has_wish'] = $builder->where('user_id', auth()->user()->id )
                                    ->where('course_id', $course->id)
                                    ->get()->getRow();
        }
                      
        $modules = $this->moduleModel->where('course_id', $course->id)->asObject()->findAll();

        if( $modules != ''){
            $lessons = [];
            $aux = 0;
            foreach ($modules as $module) {
                // first lesson, NEED FIX
                if( $aux == 0){
                    $first_lesson = $this->lessonModel->select('id')->where('module_id', $module->id)->first();
                    $data['first'] = $first_lesson['id'];
                }

                $lessons[$module->id] = $this->lessonModel->where('module_id', $module->id)->asObject()->findAll();
                $aux++;
            }
            $data['lessons_qty'] = $this->lessonModel->where('course_id', $id)->countAllResults();
            $data['module'] = $modules;
            $data['lessons'] = $lessons;
        }

        //Comments and pager, replies are in the view comments/show
        $data['comments'] = $this->commentModel->select('comments.*, CONCAT(users.name," ", users.lastname) AS commentator')
                                               ->join('users', 'users.id = comments.commentator_id')
                                               ->where('comments.section', 'courses')
                                               ->where('comments.section_id', $id)->paginate(5, 'res');

        $data['comment_pager'] = $this->commentModel->pager;
        
        $data['course'] = $course;
        
        return view('web/sections/course/show', $data);
    }

    public function join()
    {
        $lesson_id = $this->request->getGet('lesson_id');
        $course_id = $this->lessonModel->select('course_id')->where('id', $lesson_id)->get()->getRow()->course_id;

        //registrar si usuario no tiene el curso
        $db = db_connect();
        $builder = $db->table('user_has_courses');
        $user_has_courses = $builder->where('course_id', $course_id)
                                    ->where('user_id', auth()->user()->id)
                                    ->get()->getRowObject();

        if( !empty($user_has_courses)){
            $builder->where('id', $user_has_courses->id,)->update(['updated_at' => date('Y-m-d H:i:s')]);

            return redirect()->to(base_url('lesson/show/'.$lesson_id));
        }else{
            //inscribir al curso
           $data = [
            'course_id' => $course_id,
            'user_id'   => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s')
           ];

           $builder->insert($data);

           return redirect()->to(base_url('lesson/show/'.$lesson_id))->with('success', 'Se ha registrado correctamente al curso');
        }
    }
    
}
