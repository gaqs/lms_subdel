<?php
use App\Models\CategoryModel;
use App\Database;

if (! function_exists('category_list')) {
  function category_list($selected){
    
    $category = new CategoryModel();

    echo '<option value="0">Todas las categorías</option>';
    foreach ($category->findAll() as $cat){
        $thisone = ( $cat['id'] == $selected ) ? 'selected':'';
        echo '<option class="text" value="'.$cat['id'].'" '.$thisone.'>'.$cat['name'].'</option>';
        
    }
  }
} 

if (! function_exists('levels_list')) {
  function levels_list($selected){

    $db = db_connect();
    $builder = $db->table('levels')->get();

    foreach ($builder->getResultArray() as $level){
        $thisone = ( $level['id'] == $selected ) ? 'selected':'';
        echo '<option class="text" value="'.$level['id'].'" '.$thisone.'>'.$level['level'].'</option>';
        
    }
  }
} 

if (!function_exists('uploadMediaFile')) {
  /**
   * Handle the upload of video or image files.
   *
   * @param \CodeIgniter\Files\File $file           The file object to be uploaded.
   * @param string                  $filename        If file exist, then exist filename, only to reemplace old file
   * @param string                  $uploadDir      The directory where the file will be saved (relative to the 'writable/uploads' directory).
   * @param array                   $allowedTypes   Array of allowed file extensions (e.g., ['jpg', 'png', 'mp4', 'avi']).
   * 
   * @return string|false Return an array with the file path and name if successful, or false if failed.
   */
  function uploadMediaFile($file, $fileName, $post_id = '0',$uploadDir='blog', $allowedTypes = ['jpg','jpeg','png','mp4','avi', 'pdf'])
  {

    if ($file->isValid() && !$file->hasMoved()) {

        // Extract the file extension
        $extension = $file->getClientExtension();
        if (!in_array($extension, $allowedTypes)) {
            return false; // Invalid file type
        }

        $uploadPath = ROOTPATH . 'public/uploads/'. $uploadDir;

        if ($fileName != '') {
          // Delete the old file if it exists
          $oldFilePath = $uploadPath . '/' . $fileName;
          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        
        $newName = $post_id.'__'.$file->getRandomName();
        $file->move($uploadPath, $newName, true);

        return $newName;
    }

      return false; // File is not valid or has already moved
  }
}

function showFlashMessage($type, $message){

  $class = "";

  if( $type == 'error'){ $class="alert-danger"; }
  else if( $type == 'success' ){ $class="alert-success"; }

  echo '<div class="alert alert-dismissible fade show '.$class.'">'.$message.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

}