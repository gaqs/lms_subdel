<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Traits\AuthorizationTrait;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use App\Models\CourseModel;
use Config\Services;

class Module extends BaseController
{
    use AuthorizationTrait;

    protected $courseModel;
    protected $moduleModel;
    protected $lessonModel;
    protected $modelRules;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
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
        $instructorId = $this->courseModel->where('id', $this->request->getGet('course_id'))
                                          ->findColumn('instructor_id');
        //id del curso 
        $data['module'] = (object)[
            'course_id' => $this->request->getGet('course_id'),
            'instructor_id' => $instructorId[0],
        ]; 
        
        $data['action'] = 'new';
        echo view('admin/sections/module/create', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

         //verifica que el instructor del curso sea el mismo que el usuario admin logueado
        if( $redirect = $this->verifyCourseInstructor( $data['course_id'] ) ){
            return $redirect;
        }

        if( !$this->modelRules->run($data, 'module_rules')){
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }

        //verificar el order_id del modulo previamente creado en el curso o si es el primer modulo
        $lastModule = $this->moduleModel->where('course_id', $data['course_id'])->orderBy('order_id', 'DESC')->asObject()->first();
        $nextOrderId =  ($lastModule) ? intval($lastModule->order_id) + 1 : 1;

        $moduleData = [
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'order_id' => $nextOrderId,
            'description' => $data['description'],
        ];

        $this->moduleModel->insert($moduleData);

        return redirect()->to(base_url('admin/courses/edit/'.$data['course_id']))->with('success', 'Módulo creado correctamente');
    }

    public function edit($id)
    {
        $data['action'] = 'edit';
        //model e instructor id
        $data['module'] = $this->moduleModel
                               ->select('modules.*, courses.instructor_id')
                               ->join('courses', 'courses.id = modules.course_id')
                               ->where('modules.id', $id)
                               ->asObject()
                               ->first();

        return view('admin/sections/module/create', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

         //verifica que el instructor del curso sea el mismo que el usuario admin logueado
        if( $redirect = $this->verifyCourseInstructor( $data['course_id'] ) ){
            return $redirect;
        }
        //reglas de validacion
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
