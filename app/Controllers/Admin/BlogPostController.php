<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPostModel;

class BlogPostController extends BaseController
{
    protected $blogPostModel;

    public function __construct()
    {
        $this->blogPostModel = new BlogPostModel();
    }

    public function index()
    {
        $data['posts'] = $this->blogPostModel->findAll();
        return view('admin/blog_posts/index', $data);
    }

    public function create()
    {
        return view('admin/blog_posts/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]',
            'author' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'author' => $this->request->getPost('author')
        ];

        $this->blogPostModel->insert($data);
        return redirect()->to('/admin/blog-posts')->with('message', 'Blog post created successfully');
    }

    public function edit($id)
    {
        $data['post'] = $this->blogPostModel->find($id);
        if (!$data['post']) {
            return redirect()->to('/admin/blog-posts')->with('error', 'Blog post not found');
        }
        return view('admin/blog_posts/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]',
            'author' => 'required|min_length[3]|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'author' => $this->request->getPost('author')
        ];

        $this->blogPostModel->update($id, $data);
        return redirect()->to('/admin/blog-posts')->with('message', 'Blog post updated successfully');
    }

    public function delete($id)
    {
        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return redirect()->to('/admin/blog-posts')->with('error', 'Blog post not found');
        }

        $this->blogPostModel->delete($id);
        return redirect()->to('/admin/blog-posts')->with('message', 'Blog post deleted successfully');
    }
} 