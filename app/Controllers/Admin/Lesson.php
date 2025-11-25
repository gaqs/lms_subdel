<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Traits\AuthorizationTrait;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use App\Models\CourseModel;
use Config\Services;

class Lesson extends BaseController
{
    use AuthorizationTrait;

    protected $courseModel;
    protected $moduleModel;
    protected $lessonModel;
    protected $modelRules;

    public function __construct()
    {
        $this->moduleModel = new ModuleModel();
        $this->lessonModel = new LessonModel();
        $this->courseModel = new CourseModel();
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
        //id del modulo 
        $data['lesson'] = (object)[
            'module_id' => $this->request->getGet('module_id'),
            'course_id' => $this->request->getGet('course_id'),
            'instructor_id' => $instructorId[0]
        ]; 
        $data['action'] = 'new';
        return view('admin/sections/lessons/create', $data);
    }

    //modal
    public function create()
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('file');

         //verifica que el instructor del curso sea el mismo que el usuario logueado
        if( $redirect = $this->verifyCourseInstructor( $data['course_id'] ) ){
            return $redirect;
        }

        //reglas de validacion
        if( !$this->modelRules->run($data, 'lesson_rules')){
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }

        //verificar el order_id de la leccion previamente creada en el modulo o si es la primera leccion
        $lastLesson = $this->lessonModel->where('module_id', $data['module_id'])->orderBy('order_id', 'DESC')->asObject()->first();
        $nextOrderId =  ($lastLesson) ? intval($lastLesson->order_id) + 1 : 1;

        $lessonData = [
            'course_id' => $data['course_id'],
            'module_id' => $data['module_id'],
            'order_id' => $nextOrderId,
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
        //lesson and instructor if of th course
        $data['lesson'] = $this->lessonModel
                                ->select('lessons.*, courses.instructor_id')
                                ->join('courses', 'courses.id = lessons.course_id')
                                ->where('lessons.id', $id)
                                ->asObject()
                                ->first();

        return view('admin/sections/lessons/create', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

         //verifica que el instructor del curso sea el mismo que el usuario admin logueado
        if( $redirect = $this->verifyCourseInstructor( $data['course_id'] ) ){
            return $redirect;
        }

        //reglas de validacion
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

        return redirect()->to(base_url('admin/lesson/edit/'.$data['lesson_id']))->with('success', 'Lección editada correctamente');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        deleteMediaFile($id, 'lessons', 'file');
        $this->lessonModel->delete($id);

        return redirect()->back()->withInput()->with('success', 'Lección eliminada correctamente');
    }
}
