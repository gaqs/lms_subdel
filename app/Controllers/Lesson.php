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
        if( $modules != ''){
            $lessons = [];
            foreach ($modules as $module) {
                $lessons[$module->id] = $this->lessonModel->select('id,title,duration')->where('module_id', $module->id)->asObject()->findAll();
            }
            $data['module'] = $modules;
            $data['lessons'] = $lessons;
        }
        
        $data['course'] = $course;

        return view('web/sections/lessons/show', $data);
    }
}
