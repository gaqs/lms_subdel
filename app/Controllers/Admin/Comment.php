<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\CommentModel;

class Comment extends BaseController
{
    protected $commentModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();

    }
    public function index()
    {
        $data['comments'] = $this->commentModel->select('comments.*, CONCAT(users.name," ", users.lastname) AS commentator')
                                               ->join('users', 'users.id = comments.commentator_id')
                                               ->asObject()
                                               ->orderBy('comments.id', 'desc')
                                               ->findAll();
                                               

        return view('admin/sections/comments/index', $data);
    }

    public function delete()
    {
        $id = $this->request->getGet('comment_id');

        try{
            $commentData = [
                'id' => $id,
                'comment' => '<i>[Comentario eliminado]</i>'
            ];
            $this->commentModel->save($commentData);

            return redirect()->back()->with('success', 'Comentario eliminado correctamente');
            
        }catch(\Throwable $th){
            return redirect()->back()->with('success', 'Error al eliminar el comentario: '. $th);
        }


    }
}
