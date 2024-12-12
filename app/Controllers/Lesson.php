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

        $this->pagintation = Services::pager();
    }

    public function show($id)
    {
        $course_id = $this->lessonModel->select('course_id')->where('id', $id)->get()->getRow()->course_id;
        $course = $this->courseModel->asObject()->find($course_id);
        
        //data content of lesson selected on link
        $data['content'] = $this->lessonModel->select('title,description,duration,file')->where('id', $id)->get()->getRow();
                
        //listado del lado derecho
        $modules = $this->moduleModel->select('id, course_id, title')->where('course_id', $course->id)->asObject()->findAll();
        $totalLessons = 0; 
        $totalProgress = 0; 
        if( $modules != ''){
            $lessons = [];
            foreach ($modules as $module) {
                $moduleLessons = $this->lessonModel->select('lessons.id,lessons.title,lessons.duration,lessons.file,user_do_lessons.completed')
                                                   ->join('user_do_lessons', 'lessons.id = user_do_lessons.lesson_id', 'left')
                                                   ->where('lessons.module_id', $module->id)
                                                   ->asObject()->findAll();  
                    
                // Almacenar lecciones del módulo actual
                $lessons[$module->id] = $moduleLessons;

                // Calcular el progreso total
                foreach($moduleLessons as $lesson) {
                    $totalLessons++; 
                    $totalProgress += $lesson->completed; // Sumar el progreso individual
                }

            }
            $data['module'] = $modules;
            $data['lessons'] = $lessons;
        }

        $progress = ($totalLessons > 0) ? round(($totalProgress / $totalLessons), 2) : 0;
        
        $data['course'] = $course;
        $data['progress'] = $progress;

        return view('web/sections/lessons/show', $data);
    }

    public function progress()
    {
        $req = $this->request->getPost();

        $db = db_connect();
        $builder = $db->table('user_do_lessons');


        $query = $builder->select('id')
                         ->where('lesson_id', $req['lesson_id'])
                         ->get()->getRowObject();

        if( empty($query->id) ){
            $data = [
                'user_id'   => auth()->user()->id,
                'lesson_id' => $req['lesson_id'],
                'completed' => $req['progress'],
                'created_at' => date('Y-m-d H:i:s')
            ]; 

            $builder->insert($data);

        }else{
            $data = [
                'completed' => $req['progress'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $builder->where('id', $query->id,)
                    ->update($data);

        }
            
    }

}
