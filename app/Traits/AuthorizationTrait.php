<?php 

namespace App\Traits;
use App\Models\CourseModel;

trait AuthorizationTrait
{
    protected function verifyCourseInstructor( $course_id )
    {
        $courseModel = new CourseModel();
        $instructorId = $courseModel->where('id', $course_id)->findColumn('instructor_id');

        if( !$instructorId || $instructorId[0] != auth()->user()->id ){
            return redirect()->back()->withInput()->with('error', 'No tienes permisos para editar esta sección.');
        }

        return null; //if ok
    }
}

?>