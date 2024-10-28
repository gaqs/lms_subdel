<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use Config\Services;


class Blog extends BaseController
{
    protected $blogModel;
    protected $blogRules;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->blogRules = Services::validation();

    }

    public function index()
    {
        $data['posts'] = $this->blogModel->select('blogs.*, users.name, users.lastname')
                                            ->join('users','users.id = blogs.user_id')                                
                                            ->asObject()->findAll();

        return view('admin/sections/blog/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        return view('admin/sections/blog/create', ['action' => 'new']);
    }


    public function create()
    {
        $data = $this->request->getPost();

        if(!$this->blogRules->run($data, 'blog_rules')){ //run rules of validation of data for blog
            return redirect()->back()->withInput()->with('errors', $this->blogRules->getErrors());
        }
        $file = $this->request->getFile('file');
        $image = $this->request->getFile('image');

        $publish = isset($data['publish']) ? 'publish':'draft';

        $blogData = [
            'title' => $data['title'],
            'category_id' => (int)$data['category'],
            'user_id' => auth()->user()->id,
            'status' => $publish,
            'description' => $data['description'],
            'keywords' => $data['keywords'],
        ]; 

        $this->blogModel->insert($blogData);

        $id = $this->blogModel->getInsertID();

        $filename = $file->getSize() > 0 ? uploadMediaFile($file, '', $id) : null; 
        $imagename = $image->getSize() > 0 ? uploadMediaFile($image, '', $id) : null; 

        $fileData = [
            'id' => $id,
            'image' => $imagename,
            'file' => $filename,
        ];

        $this->blogModel->save($fileData);

        return redirect()->to(base_url('admin/blogs/edit/'.$id))->with('success', 'Post agregado correctamente.');
            
    }

    public function edit($id = null)
    {
        $data['action'] = 'edit';
        $data['post'] = $this->blogModel->asObject()->find($id);

        return view('admin/sections/blog/create', $data);
    }
    
    public function update($id = null)
    {
        $data = $this->request->getPost();

        if(!$this->blogRules->run($data, 'blog_rules')){
            return redirect()->back()->withInput()->with('errors', $this->blogRules->getErrors());
        }
        $file = $this->request->getFile('file');
        $image = $this->request->getFile('image');

        $upload = $file->getSize() > 0 ? uploadMediaFile($file, $data['file_name'], $data['id']) : $data['file_name']; 
        $imagename = $image->getSize() > 0 ? uploadMediaFile($image, $data['image_name'], $data['id']) : $data['image_name']; 

        $publish = isset($data['publish']) ? 'publish':'draft';

        $blogData = [
            'id' => $data['id'],
            'title' => $data['title'],
            'category_id' => (int)$data['category'],
            'status' => $publish,
            'image' => $imagename,
            'description' => $data['description'],
            'file' => $upload,
            'keywords' => $data['keywords'],
        ]; 
        $this->blogModel->save($blogData);

        return redirect()->to(base_url('admin/blogs/edit/'.$data['id']))->with('success', 'Post actualizado correctamente.');
    }

    public function delete($id = null)
    {
        $id = $this->request->getPost('id');

        deleteMediaFile($id,'blogs', 'file');
        deleteMediaFile($id, 'blogs', 'image');

        $this->blogModel->delete($id);
        return redirect()->back()->with('success', 'Post eliminado correctamente');

    }

}
