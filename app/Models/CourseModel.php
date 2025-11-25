<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','instructor_id','title','resume','category_id','status', 'level_id','duration','keywords','description','image','created_at','updated_at','deleted_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function beforeInsert(array $data){
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }
    
      protected function beforeUpdate(array $data){
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function updateCourseDuration(array $data)
    {
        if(!empty($data)){
            $course_id = $data['data']['course_id'];
    
            // Obtiene la duración total del curso
            $query = $this->select('SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) as total_duration')
                                ->where('course_id', $course_id)
                                ->get()
                                ->getRow();
        
            // Actualiza la columna "duration" en la tabla "courses"
            $courseModel = new \App\Models\CourseModel();
            $courseModel->update($course_id, ['duration' => $query->total_duration]);
        }
        
    }

}
