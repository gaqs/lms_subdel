<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Home extends BaseController
{

    public function index()
    {
        return view('admin/sections/index');
    }

    public function show($id = null)
    {
        //
    }

    public function new()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
    }

    public function upload_media()
    {
        $file = $this->request->getFile('file');

        if( $file->isValid() && !$file->hasMoved() ){
            
            $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
            $maxSize =  20000; //20 mb

            $fileName = uploadMediaFile($file,'',uniqid(),'media', $allowedTypes, $maxSize);

            if( $fileName ){
                return $this->response->setJSON([
                    'success' => true,
                    'file' => base_url('public/uploads/media/'.$fileName),
                ]);
            }
        }
        
    }

    public function delete_media()
    {
        $id = $this->request->getGet('id');
        $type = $this->request->getGet('type');
        $folder = $this->request->getGet('folder');

        $delete = deleteMediaFile($id, $folder, $type);

        if($delete){
            return redirect()->back()->with('success', 'Archivo eliminado correctamente');
        }else{
            return redirect()->back()->with('error', 'Error al eliminar el archivo');
        }
    }
}
