<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Module extends BaseController
{
    protected $moduleModel;
    protected $lessonModel;
    protected $modelRules;

    public function __construct()
    {
        $this->moduleModel = new ModuleModel();
        $this->lessonModel = new LessonModel();
        $this->modelRules = Services::validation();
    }

    public function index()
    {
        //
    }

    public function new()
    {
        //id del curso 
        $data['module'] = (object)[
            'course_id' => $this->request->getGet('course_id')
        ]; 
        
        $data['action'] = 'new';
        echo view('admin/sections/module/create', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if( !$this->modelRules->run($data, 'module_rules')){
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }

        $moduleData = [
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ];

        $this->moduleModel->insert($moduleData);

        return redirect()->to(base_url('admin/courses/edit/'.$data['course_id']))->with('success', 'Módulo creado correctamente');
    }

    public function edit($id)
    {
        $data['action'] = 'edit';
        $data['module'] = $this->moduleModel->asObject()->find($id);
        return view('admin/sections/module/create', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        if( !$this->modelRules->run($data, 'module_rules')){
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }

        $moduleData = [
            'id' => $data['module_id'],
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ];

        $this->moduleModel->save($moduleData);

        return redirect()->to(base_url('admin/courses/edit/'.$data['course_id']))->with('success', 'Módulo editado correctamente');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        
        // Delete lessons
        $lessons = $this->lessonModel->where('module_id', $id)->asObject()->findAll();
        foreach ($lessons as $lesson) {
            deleteMediaFile($lesson->id, 'lessons', 'file');
            $this->lessonModel->delete($lesson->id);
        }
        // Delete module
        $this->moduleModel->delete($id);
        
        return redirect()->back()->withInput()->with('success', 'Módulo y lecciones eliminados correctamente');
    }
}
