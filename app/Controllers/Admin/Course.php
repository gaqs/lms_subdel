<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Traits\AuthorizationTrait;
use App\Models\CourseModel;
use App\Models\LessonModel;
use App\Models\ModuleModel;
use App\Models\CommentModel;
use Config\Services;

class Course extends BaseController
{
    use AuthorizationTrait;

    protected $courseModel;
    protected $moduleModel;
    protected $lessonModel;
    protected $commentModel;
    protected $modelRules;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->lessonModel = new LessonModel();
        $this->moduleModel = new ModuleModel();
        $this->commentModel = new CommentModel();

        $this->modelRules = Services::validation();
    }

    public function index()
    {
        $data['cursos'] = $this->courseModel->select('courses.*, levels.level as level, categories.name as category_name, users.name as username, users.id as userid, users.lastname as userlastname')
                                        ->join('categories', 'courses.category_id = categories.id')
                                        ->join('levels', 'courses.level_id = levels.id')
                                        ->join('users', 'courses.instructor_id = users.id')
                                        ->asObject()->findAll();

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
            'resume' => $data['resume'],
            'category_id' => (int)$data['category'],
            'status' => $publish,
            'level_id' => (int)$data['level'],
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

        $modules = $this->moduleModel->where('course_id', $course->id)->orderBy('order_id')->asObject()->findAll();

        $lessons = [];

        //verificar si existen modulos creados
        if( !empty($modules )){
            foreach ($modules as $module) {
                //verificar si el modulo tiene lecciones asociadas
                $lesson = $this->lessonModel->where('module_id', $module->id)->first();
                if (!empty($lesson)) {
                    $lessons[$module->id] = $this->lessonModel->where('module_id', $module->id)->orderBy('order_id')->asObject()->findAll();
                } 
            }
        }

        $data['course'] = $course;
        $data['module'] = $modules;
        $data['lessons'] = $lessons;

        return view('admin/sections/courses/create', $data);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        
        $course_id = $data['course_id'];
        //verifica que el instructor del curso sea el mismo que el usuario logueado
        if( $redirect = $this->verifyCourseInstructor( $course_id ) ){
            return $redirect;
        }
        //run rules of validation of data for blog
        if(!$this->modelRules->run($data, 'course_rules')){ 
            return redirect()->back()->withInput()->with('errors', $this->modelRules->getErrors());
        }
        $image = $this->request->getFile('image');
        $imagename = $image->getSize() > 0 ? uploadMediaFile($image, $data['image_name'], $data['course_id'],'courses') : $data['image_name']; 

        $publish = isset($data['publish']) ? 'publish':'draft';

        $courseData = [
            'id' => $course_id,
            'title' => $data['title'],
            'resume' => $data['resume'],
            'category_id' => (int)$data['category'],
            'status' => $publish,
            'level_id' => (int)$data['level'],
            'image' => $imagename,
            'description' => $data['description'],
            'keywords' => $data['keywords']
        ]; 

        $this->courseModel->save($courseData);

        if (!isset($data['course'][$course_id])) {
            //si no hay modulos, redirigir
            return redirect()->to(base_url('admin/courses/edit/'.$data['course_id']))->with('success', 'Curso editado correctamente.');
        }
        
        $modules = $data['course'][$course_id]; //course[id_curso][order] = id_modulo - El curso siempre va a ser uno solo
        $lessons = isset($data['module']) ? $data['module'] : ''; //module[id_modulo][order] = id_lesson

        //actualizar orden de modulos por id
        if(!empty($modules)){
            foreach ( $modules as $order => $module_id){
                $order = $order + 1;
                $this->moduleModel->update($module_id, ['order_id' => $order]);
            }
        }
        //actualizar orden de lecciones por id
        if(!empty($lessons)){
            foreach( $lessons as $module_id => $lesson_array){
                foreach( $lesson_array as $order => $lesson_id){
                    $order = $order + 1;
                    $this->lessonModel->update($lesson_id, ['order_id' => $order]);
                }
            }
        }
        
        return redirect()->to(base_url('admin/courses/edit/'.$data['course_id']))->with('success', 'Curso editado correctamente.');
    }

    public function delete($id = null)
    {
        //Al borrar cursos, hay que borrar los modulos y lecciones pertenecientes al curso. (softdelete)
        $id = $this->request->getPost('id'); //course_id

        // Delete lessons
        $modules = $this->moduleModel->where('course_id', $id)->asObject()->findAll();
        foreach ($modules as $module) {
            $lessons = $this->lessonModel->where('module_id', $module->id)->asObject()->findAll();
            foreach ($lessons as $lesson) {
                //deleteMediaFile($lesson->id, 'lessons', 'file');
                $this->lessonModel->delete($lesson->id);
            }
            $this->moduleModel->delete($module->id);
        }

        //delete comments asociados al curso
        $comments = $this->commentModel->where('section', 'courses')
                                       ->where('section_id', $id)
                                       ->asObject()
                                       ->findAll();

        foreach ($comments as $comment) {
            $this->commentModel->delete($comment->id);
        }

        //deleteMediaFile($id, 'courses', 'image');
        $this->courseModel->delete($id);
        
        return redirect()->back()->with('success', 'Curso eliminado correctamente');
    }
}
