<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validation\RutValidation;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        RutValidation::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules  of Registration
    // --------------------------------------------------------------------
    public $registration = [
        'name' => [
            'label' => 'Nombre',
            'rules' => [
                'required',
                'min_length[3]',
                'max_length[254]',
            ],
        ],
        'lastname' => [
            'label' => 'Apellido',
            'rules' => [
                'required',
                'min_length[3]',
                'max_length[254]',
            ],
        ],
        //RUT 55555555-5
        'username' => [
            'label' => 'RUT',
            'rules' => [
                'required',
                'max_length[11]',
                'min_length[3]',
                'regex_match[^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$]',
                'is_unique[users.username]',
                'validate_rut[users.username]',
            ],
            'errors' => [
                'validate_rut' => 'RUT ingresado contiene errores.'
            ],
        ],
        'email' => [
            'label' => 'Correo',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'password' => [
            'label' => 'Contraseña',
            'rules' => 'required|max_byte[72]|strong_password[]',
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes'
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];
    
    // --------------------------------------------------------------------
    // Rules  of Blogs
    // --------------------------------------------------------------------
    public $blog_rules = [
        'title' => [ 
            'label' => 'titulo',     
            'rules' => 'required|min_length[5]|max_length[100]' 
        ], 
        'category' => [ 
            'label' => 'categoria',  
            'rules' => 'required' 
        ],
        'image' => [ 
            'label' => 'La imagen',    
            'rules' => 'max_size[image,20000]|ext_in[image,jpg,jpeg,png]' 
        ],
        'description' => [ 
            'label' => 'descripción',
            'rules' => 'required|min_length[50]' 
        ],
        'keywords' => [ 
            'label' => 'keywords',   
            'rules' => 'required|min_length[5]' 
        ],
        'file' => [ 
            'label' => 'El archivo',    
            'rules' => 'max_size[file,200000]|ext_in[file,mp4,pdf]' 
        ]
    ];

    // --------------------------------------------------------------------
    // Rules of Courses
    // --------------------------------------------------------------------
    public $course_rules = [
        'title' => [ 
            'label' => 'titulo',     
            'rules' => 'required|min_length[5]|max_length[100]' 
        ], 
        'category' => [ 
            'label' => 'categoria',  
            'rules' => 'required' 
        ],
        'duration' => [
            'label' => 'duración',
            'rules' => 'required|numeric'
        ],
        'keywords' => [ 
            'label' => 'keywords',   
            'rules' => 'required|min_length[5]' 
        ],
        'description' => [ 
            'label' => 'descripción',
            'rules' => 'required|min_length[50]' 
        ]
    ];

    // --------------------------------------------------------------------
    // Rules of modules
    // --------------------------------------------------------------------
    public $module_rules = [
        'title' => [ 
            'label' => 'titulo',     
            'rules' => 'required|min_length[5]|max_length[100]' 
        ], 
        'duration' => [
            'label' => 'duración',
            'rules' => 'required|numeric'
        ],
        'description' => [ 
            'label' => 'descripción',
            'rules' => 'required|min_length[50]' 
        ],
    ];


    // --------------------------------------------------------------------
    // Rules of Lessons
    // --------------------------------------------------------------------
    public $lesson_rules = [
        'title' => [ 
            'label' => 'titulo',     
            'rules' => 'required|min_length[5]|max_length[100]' 
        ], 
        'duration' => [
            'label' => 'duración',
            'rules' => 'required|numeric'
        ],
        'keywords' => [ 
            'label' => 'keywords',   
            'rules' => 'required|min_length[5]' 
        ],
        'description' => [ 
            'label' => 'descripción',
            'rules' => 'required|min_length[50]' 
        ],
        'file' => [ 
            'label' => 'El archivo adjunto',    
            'rules' => 'max_size[file,2000000]|ext_in[file,mp4,pdf]' 
        ]     
    ];

}
