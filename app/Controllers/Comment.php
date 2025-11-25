<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommentModel;
use CodeIgniter\HTTP\ResponseInterface;

class Comment extends BaseController
{
    protected $commentModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();

    }
    public function index()
    {
        //
    }

    public function show()
    {

    }

    public function new()
    {

    }

    public function create()
    {
        $data = $this->request->getPost();
        try {
            $commentData = [
                'parent_comment_id' => $data['tbl_comment_id'] ?? '',
                'section'           => $data['section'] ?? '',
                'section_id'        => $data['section_id'] ?? '',
                'commentator_id'    => $data['commentator_id'],
                'comment'           => $data['comment'],
            ];

            // dd($commentData);
    
            $this->commentModel->insert($commentData);

            $id = $this->commentModel->getInsertID();
            
            return redirect()->to(previous_url().'#comment-'.$id)->with('success', 'Comentario añadido correctamente');
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', 'Error al subir el comentario: '. $th);
        }
    }


    public function edit()
    {
        
    }

    public function update()
    {
        $data = $this->request->getPost();
        try {
            $commentData = [
                'id'              => $data['tbl_comment_id'] ?? $data['tbl_reply_id'],
                'commentator_id'  => $data['commentator_id'] ?? $data['replier'],
                'comment'         => $data['comment'] ?? $data['reply'],
            ];

            $this->commentModel->save($commentData);
            
            return redirect()->back()->with('success', 'Comentario actualizado correctamente');
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('success', 'Error al actualizad el comentario: '. $th);
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('comment_id');

        try{
            $commentData = [
                'id' => $id,
                'comment' => '<i><small>[Comentario eliminado]</small></i>'
            ];
            $this->commentModel->save($commentData);

            return redirect()->back()->with('success', 'Comentario actualizado correctamente');
            
        }catch(\Throwable $th){
            return redirect()->back()->with('success', 'Error al actualizad el comentario: '. $th);
        }


    }
}
