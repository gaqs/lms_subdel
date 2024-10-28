<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;

class Users extends BaseController
{
    
    public function index()
    {
        //Codeigniter Default Shield User Model
        $users = auth()->getProvider();

        $data['users'] = $users->findAll();

        return view('admin/sections/users/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        $data['action'] = 'new';

        return view('admin/sections/users/create', $data);
    }

    
    public function create()
    {
        $request = $this->request->getPost();
        $users = auth()->getProvider();
    
        $active = isset($request['validated']) ? 1:0;

        $validate_email = $users->findByCredentials([ 'email' => $request['email'] ]);
        $validate_user = $users->findByCredentials([ 'username' => $request['username'] ]);
        
        if( $validate_email != '' ||  $validate_user != '' ){
            return redirect()->back()->withInput()->with('errors', 'RUT o Correo ya utilizado');
        }

        $user = new User([
            'username' => $request['username'],
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'active' => $active,
            'password' => $request['password'],
        ]);

        $users->save($user);

        $user = $users->findById($users->getInsertID());

        if( isset($request['admin']) ){
            $user->addGroup('admin');
        }else{
            $users->addToDefaultGroup($user);
        }

        return redirect()->to(base_url('admin/user/edit/'.$users->getInsertID() ))->with('success', 'Usuario creado correctamente.');
        
    }


    public function edit($id = null)
    {
        $user = auth()->getPRovider();
        $data['user']= $user->findById($id);

        $db = db_connect();
        $query = $db->table('auth_groups_users') ->where('user_id', $id) ->get() ->getRow();

        if( !empty($query)){
            if( $query->group == 'admin' || $query->group == 'superadmin' ){
                $data['user']->admin = true;
            }else{
                $data['user']->admin = false;
            }
        }
        

        $data['action'] = 'edit';

        return view('admin/sections/users/create', $data);
    }


    public function update($id = null)
    { 
        $request = $this->request->getPost();
        $users = auth()->getProvider();

        $user = $users->findById($request['id']);

        $active = isset($request['validated']) ? 1:0;
    
        $user->fill([
            'username' => $request['username'],
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'active' => $active,
            'password' => $request['password'],
        ]);

        $users->save($user);

        if( isset($request['admin']) ){
            $user->removeGroup('user');
            $user->addGroup('admin');
        }else{
            $user->removeGroup('admin');
            $users->addToDefaultGroup($user);
        }
        

        return redirect()->back()->withInput()->with('success', 'Usuario editado correctamente');

    }


    public function delete($id = null)
    {
        $request = $this->request->getPost();
        $users = auth()->getProvider();

        $users->delete($request['id']);
    }
}
