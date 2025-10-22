<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\CourseModel;
use App\Models\LessonModel;
use App\Models\ModuleModel;

use Config\Services;

class Lesson extends BaseController
{
    protected $categoryModel;
    protected $moduleModel;
    protected $courseModel;
    protected $lessonModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->courseModel   = new CourseModel();
        $this->lessonModel   = new LessonModel();
        $this->moduleModel   = new ModuleModel();

    }

    public function show($id)
    {
        $course_id = $this->lessonModel->select('course_id')->where('id', $id)->get()->getRow()->course_id;
        $course = $this->courseModel->asObject()->find($course_id);
        
        //data content of lesson selected on link
        $data['content'] = $this->lessonModel->select('title,description,duration,file')->where('id', $id)->get()->getRow();
                
        //listado del lado derecho
        $modules = $this->moduleModel->select('id, course_id, title')->where('course_id', $course->id)->asObject()->findAll();

        if( $modules != ''){
            $lessons = [];
            foreach ($modules as $module) {
                $moduleLessons = $this->lessonModel->select('lessons.id,lessons.title,lessons.duration,lessons.file,user_do_lessons.completed')
                                                   ->join('user_do_lessons', 'lessons.id = user_do_lessons.lesson_id', 'left')
                                                   ->where('lessons.module_id', $module->id)
                                                   ->asObject()->findAll();  
                    
                // Almacenar lecciones del módulo actual
                $lessons[$module->id] = $moduleLessons;
            }

            //verifica si termino el curso en algun momento de la historia
            $db = db_connect();
            $course_progress = $db->table('user_has_courses')
                                  ->select('id,complete,token,updated_at')
                                  ->where('course_id', $course->id)
                                  ->where('user_id', auth()->user()->id)
                                  ->get()->getRowObject();

            $data['course_progress'] = $course_progress;
            $data['module'] = $modules;
            $data['lessons'] = $lessons;
        }

       
        $data['course'] = $course;

        return view('web/sections/lessons/show', $data);
    }

    public function progress()
    {
        $req = $this->request->getPost();

        $db = db_connect();
        $user_do_lessons = $db->table('user_do_lessons');

        $query = $user_do_lessons->select('id')
                                ->where('lesson_id', $req['lesson_id'])
                                ->get()->getRowObject();

        if( empty($query->id) ){
            $data = [
                'user_id'   => auth()->user()->id,
                'course_id' => $req['course_id'],
                'lesson_id' => $req['lesson_id'],
                'completed' => $req['progress'],
                'created_at' => date('Y-m-d H:i:s')
            ]; 

            $user_do_lessons->insert($data);

        }else{
            $data = [
                'completed' => $req['progress'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $user_do_lessons->where('id', $query->id,)
                            ->update($data);
        }     
    }

    public function check_live_progress()
    {
        $course_id = $this->request->getPost('course_id');
        
        $modules = $this->moduleModel->select('id, course_id, title')->where('course_id', $course_id)->asObject()->findAll();
        $totalLessons = 0; 
        $totalProgress = 0; 
        if( $modules != ''){
            foreach ($modules as $module) {
                $moduleLessons = $this->lessonModel->select('lessons.id,lessons.title,lessons.duration,lessons.file,user_do_lessons.completed')
                                                   ->join('user_do_lessons', 'lessons.id = user_do_lessons.lesson_id', 'left')
                                                   ->where('lessons.module_id', $module->id)
                                                   ->asObject()->findAll();  
                // Calcular el progreso total
                foreach($moduleLessons as $lesson) {
                    $totalLessons++; 
                    $totalProgress += $lesson->completed; // Sumar el progreso individual
                }
            }
        }

        $progress = ($totalLessons > 0) ? round(($totalProgress / $totalLessons), 2) : 0;

        //verificar si en algun momento completo el curso
        $db = db_connect();
        $user_do_courses = $db->table('user_has_courses');
        
        $course = $user_do_courses->where('course_id', $course_id)
                                  ->where('user_id', auth()->user()->id)
                                  ->get()->getRowObject();

        if( $progress == 100 && $course->complete == 0 ){
            $token  = generate_certify_token();
            $code   = generate_certify_code();
            $data = [
                'complete' => 1,
                'token' => $token,
                'code' => $code,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            //guardar que completo el curso
            $user_do_courses->where('id', $course->id)
                            ->where('user_id', auth()->user()->id)
                            ->update($data);
        }

        echo $progress ?? 0;
    }

}
