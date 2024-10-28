<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Lesson extends BaseController
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
        //id del modulo 
        $data['lesson'] = (object)[
            'module_id' => $this->request->getGet('module_id'),
            'course_id' => $this->request->getGet('course_id'),
        ]; 
        $data['action'] = 'new';
        return view('admin/sections/lessons/create', $data);
    }

    //modal
    public function create()
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('file');

        if( !$this->modelRules->run($data, 'lesson_rules')){
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }

        $lessonData = [
            'course_id' => $data['course_id'],
            'module_id' => $data['module_id'],
            'title' => $data['title'],
            'duration' => $data['duration'],
            'keywords' => $data['keywords'],
            'description' => $data['description'],
        ];

        $this->lessonModel->insert($lessonData);

        $id = $this->lessonModel->getInsertID();

        $filename = $file->getSize() > 0 ? uploadMediaFile($file, '', $id, 'lessons') : null; 
        $fileData = [
            'id' => $id,
            'file' => $filename,
        ];

        $this->lessonModel->save($fileData);

        //recueprar la id del curso
        $course_id = $this->moduleModel->where('id', $data['module_id'])->findColumn('course_id');

        return redirect()->to(base_url('admin/courses/edit/'.$course_id[0]))->with('success', 'Lección creada correctamente');
        
    }

    public function edit($id)
    {
        $data['action'] = 'edit';
        $data['lesson'] = $this->lessonModel->asObject()->find($id);
        return view('admin/sections/lessons/create', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        if( !$this->modelRules->run($data, 'lesson_rules')){
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }

        $file = $this->request->getFile('file');
        $filename = $file->getSize() > 0 ? uploadMediaFile($file, $data['file_name'], $data['lesson_id'], 'lessons') : $data['file_name']; 

        $lessonData = [
            'id' => $data['lesson_id'],
            'course_id' => $data['course_id'],
            'module_id' => $data['module_id'],
            'title' => $data['title'],
            'duration' => $data['duration'],
            'keywords' => $data['keywords'],
            'description' => $data['description'],
            'file' => $filename
        ];

        $this->lessonModel->save($lessonData);

        return redirect()->back()->withInput()->with('success', 'Lección editada correctamente');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        deleteMediaFile($id, 'lessons', 'file');
        $this->lessonModel->delete($id);

        return redirect()->back()->withInput()->with('success', 'Lección eliminada correctamente');
    }
}
