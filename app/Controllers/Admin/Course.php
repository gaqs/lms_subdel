<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use Config\Services;

class Course extends BaseController
{
    protected $courseModel;
    protected $moduleModel;
    protected $lessonModel;
    protected $modelRules;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->lessonModel = new LessonModel();
        $this->moduleModel = new ModuleModel();
        
        $this->modelRules = Services::validation();
    }

    public function index()
    {
        $data['cursos'] = $this->courseModel->asObject()
                                            ->findAll();
    
        return view('admin/sections/courses/index', $data);
    }

    public function show($id = null)
    {
        //
    }

    public function new()
    {
        return view('admin/sections/courses/create', ['action' => 'new']);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if(!$this->modelRules->run($data, 'course_rules')){ //run rules of validation of data for blog
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }
        $image = $this->request->getFile('image');

        $publish = isset($data['publish']) ? 'publish':'draft';

        $courseData = [
            'instructor_id' => auth()->user()->id,
            'title' => $data['title'],
            'category_id' => (int)$data['category'],
            'status' => $publish,
            'level_id' => (int)$data['level'],
            'duration' => (int)$data['duration'],
            'description' => $data['description'],
            'keywords' => $data['keywords']
        ]; 

        $this->courseModel->insert($courseData);

        $id = $this->courseModel->getInsertID();

        $imagename = $image->getSize() > 0 ? uploadMediaFile($image, '', $id, 'courses') : null; 

        $fileData = [
            'id' => $id,
            'image' => $imagename
        ];

        $this->courseModel->save($fileData);

        return redirect()->to(base_url('admin/courses/edit/'.$id))->with('success', 'Curso generado correctamente. Ahora puede agregar modulos y lecciones.');
    }

    public function edit($id = null)
    {
        $data['action'] = 'edit';
        $course = $this->courseModel->asObject()->find($id);

        $modules = $this->moduleModel->where('course_id', $course->id)->asObject()->findAll();

        $lessons = [];
        foreach ($modules as $module) {
            $lessons[$module->id] = $this->lessonModel->where('module_id', $module->id)->asObject()->findAll();
        }

        $data['course'] = $course;
        $data['module'] = $modules;
        $data['lessons'] = $lessons;

        return view('admin/sections/courses/create', $data);
    }

    public function update($id = null)
    {
        //
    }

    public function delete($id = null)
    {
        //
    }
}
