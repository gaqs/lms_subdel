<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use Config\Services;

class Blog extends BaseController
{
    protected $blogModel;
    protected $categoryModel;
    protected $commentModel;
    protected $pagination;
    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->categoryModel = new CategoryModel();
        $this->commentModel = new CommentModel();

        $this->pagination = Services::pager();
    }

    public function index()
    {
        $categories = $this->request->getGET('cat');

        $builder = $this->blogModel->select('blogs.*, users.name, users.lastname')
                                    ->join('users', 'users.id = blogs.user_id')
                                    ->where('blogs.status', 'publish')
                                    ->orderBy('users.id', 'DESC')
                                    ->asObject();

        if( empty($categories) || in_array(0,$categories) || $categories == null ){
            $builder = $builder->paginate(6, 'res');
        }else{
            $builder = $builder->whereIn('category_id', $categories)
                                ->paginate(6, 'res');
        }

        $cat = $this->categoryModel->asObject()->findAll();
        $data = [
            'posts' => $builder,
            'pager' => $this->blogModel->pager,
            'cat' => $cat
        ];
        return view('web/sections/blog/index', $data);
    }

    public function show($id = null)
    {
        $data['post'] = $this->blogModel->select('blogs.*, users.name, users.lastname')
                                        ->join('users', 'users.id = blogs.user_id')
                                        ->orderBy('users.id', 'RANDOM')
                                        ->limit(3)
                                        ->asObject()
                                        ->find($id);

        $data['posts'] = $this->blogModel->select('blogs.*, users.name, users.lastname')
                                    ->join('users', 'users.id = blogs.user_id')
                                    ->where('blogs.id !=', $id)
                                    ->orderBy('users.id', 'RANDOM')
                                    ->asObject()->findAll(3);
        
        //Comments and pager, replies are in the view comments/show
        $data['comments'] = $this->commentModel->select('comments.*, CONCAT(users.name," ", users.lastname) AS commentator')
                                               ->join('users', 'users.id = comments.commentator_id')
                                               ->where('comments.section', 'blogs')
                                               ->where('comments.section_id', $id)->paginate(5, 'res');

        $data['comment_pager'] = $this->commentModel->pager;


        $db = db_connect();
        $builder = $db->table('user_has_wishes');
        
        $data['has_wish'] = '';
        if( isset( auth()->user()->id )){
            $data['has_wish'] = $builder->where('user_id', auth()->user()->id )
                                        ->where('blog_id', $id)
                                        ->get()->getRow();
        }

        return view('web/sections/blog/show', $data);
    }
}
