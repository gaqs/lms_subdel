<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CourseModel;

use Spipu\Html2Pdf\Html2Pdf;

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

        $config = [
            'protocol'   => 'smtp',
            'SMTPHost'   => env('email.help.SMTPHost'),
            'SMTPUser'   => env('email.help.SMTPUser'),
            'SMTPPass'   => env('email.help.SMTPPass'),
            'SMTPPort'   => 587,
            'SMTPCrypto' => 'tls',
            'mailType'   => 'text',
            'charset'    => 'UTF-8',
            'userAgent'  => 'LMS',
        ];

        $email = service('email');
        $email->initialize($config);

        $email->setFrom($data['email'], $data['name']);
        $email->setTo('support@subdelpuertomontt.cl');
        $email->setSubject($data['subject']);
        $email->setMessage($data['message']);

        if (! $email->send()) {
            
            // Obtener información de depuración del email
            $debug = $email->printDebugger(['headers', 'subject', 'body']);
            // Loguear siempre el debug (evita exponer credenciales a usuarios)
            log_message('error', 'Email send failed: ' . $debug);
            // Mostrar detalle solo en entorno development
            if (ENVIRONMENT === 'development') {
                return redirect()->to(base_url('#help'))->withInput()->with('error', 'No fue posible enviar el mensaje. Debug: ' . $debug);
            }
            return redirect()->to(base_url('#help'))->withInput()->with('error', 'No fue posible enviar el mensaje.');
        }else{
            $session->set('email_count', $session->get('email_count') + 1);
            return redirect()->to(base_url('#help'))->withInput()->with('success', 'Mensaje enviado correctamente.');
        }   
    }


    public function certificate()
    {
        $db = db_connect();

        $id = $this->request->getGet('id');
        $token = $this->request->getGet('token');

        if(!$id || !$token){
            return redirect()->to(base_url())->with('error', 'No es posible generar el certificado. Inténtalo de nuevo.');
        }

        //consulta a la base de datos user_has_courses que tiene user_id y course_id
        $query = $db->table('user_has_courses')
                    ->select('users.name,users.lastname,courses.title as course_name,courses.duration,user_has_courses.id,user_has_courses.token,user_has_courses.code,user_has_courses.updated_at')
                    ->join('users', 'users.id = user_has_courses.user_id')
                    ->join('courses', 'courses.id = user_has_courses.course_id')
                    ->where('user_has_courses.id', $id)
                    ->where('user_has_courses.token', $token)
                    ->where('user_has_courses.complete', 1)
                    ->get()
                    ->getResultObject();

        $data['course'] = $query[0];

        // Generar el contenido HTML para el PDF
        $htmlContent = view('web/layout/certificate', $data);

        // Crear el PDF
        $html2pdf = new Html2Pdf('L', 'A4', 'es', true, 'UTF-8', 3);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($htmlContent);

        // Guardar el PDF en un archivo temporal
        $filePath = ROOTPATH . 'public/pdfs/certificate.pdf';
        $html2pdf->output($filePath, 'F');

        $data['pdfPath'] = base_url('public/pdfs/certificate.pdf');

        // Pasar la ruta del archivo a la vista
        return view('web/sections/static/certificate', $data);
    }

    public function verify()
    {
        $token = $this->request->getGet('token');
        $code = $this->request->getGet('code');

        $db = db_connect();
        $query = $db->table('user_has_courses')
                    ->select('users.name,users.lastname,courses.title as course_name,courses.duration,user_has_courses.id,user_has_courses.token,user_has_courses.code,user_has_courses.updated_at')
                    ->join('users', 'users.id = user_has_courses.user_id')
                    ->join('courses', 'courses.id = user_has_courses.course_id');
                    
        if( $token ){
            $query->where('user_has_courses.token', $token);
        }else if($code){
            $query->where('user_has_courses.code', 'CERT-'.$code);
        }else{
            $query->where('user_has_courses.id', 0); //no results
        }

        $query = $query->get()
                       ->getResultObject();

        if(empty($query)){
            $data['error'] = 'Ingrese el código del certificado o ingrese via link';
        }else{
            $data['verify'] = $query[0];
        }    

        return view('web/sections/static/verify', $data);
    }

    public function ttcc()
    {
        return view('web/sections/static/ttcc');
    }
}
