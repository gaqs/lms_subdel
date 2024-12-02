<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CourseModel;

use Config\Services;

class Home extends BaseController
{
    protected $courseModel;
    protected $categoryModel;
    protected $modelRules;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->categoryModel = new CategoryModel();

        $this->modelRules = Services::validation();
    }

    public function index(): string
    {
        $data['courses'] = $this->courseModel->select('courses.*, users.name, users.lastname, categories.name as category_name, categories.color, (SELECT COUNT(id) FROM lessons WHERE lessons.course_id = courses.id) as lesson_qty')
                                             ->join('users', 'users.id = courses.instructor_id')
                                             ->join('categories', 'categories.id = courses.category_id')
                                             ->where('courses.status', 'publish')
                                             ->orderBy('users.id', 'DESC')
                                             ->asObject()
                                             ->findAll();

        $data['categories'] = $this->categoryModel->asObject()
                                                  ->orderBy('id','RANDOM')
                                                  ->get(4)
                                                  ->getResult();

        return view('web/sections/index', $data);
    }

    public function help()
    {
        // Obtener el servicio de sesión
        $session = session();
        // Verificar el límite de correos
        $limitCheck = checkEmailLimit(1, $session);
        if ($limitCheck !== true) {
            return redirect()->to(base_url('#help'))->withInput()->with('error', $limitCheck);
        }
        
        $data = $this->request->getPost();

        if(!$this->modelRules->run($data, 'help_rules')){ //run rules of validation of data for blog
            return redirect()->to(base_url('#help'))->withInput()->with('errors', $this->modelRules->getErrors());
        }

        $email = service('email');

        //$email->setFrom($data['email'], $data['name']);
        $email->setTo($data['email']);
        $email->setSubject($data['subject']);
        $email->setMessage($data['message']);

        if (! $email->send()) {
            return redirect()->to(base_url('#help'))->withInput()->with('error', 'No fue posible enviar el mensaje.');
        }else{
            $session->set('email_count', $session->get('email_count') + 1);
            return redirect()->to(base_url('#help'))->withInput()->with('success', 'Mensaje enviado correctamente.');
        }

        
    }
}
