<?php

namespace App\Controllers;

use App\Models\PostModel;

class PostController extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    public function index()
    {
        $data['posts'] = $this->postModel->findAll();
        return view('posts/index', $data);
    }

    public function create()
    {
        return view('posts/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ];

        $this->postModel->insert($data);
        return redirect()->to('/posts')->with('message', 'Post created successfully');
    }

    public function edit($id)
    {
        $data['post'] = $this->postModel->find($id);
        if (empty($data['post'])) {
            return redirect()->to('/posts')->with('error', 'Post not found');
        }
        return view('posts/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ];

        $this->postModel->update($id, $data);
        return redirect()->to('/posts')->with('message', 'Post updated successfully');
    }

    public function delete($id)
    {
        $this->postModel->delete($id);
        return redirect()->to('/posts')->with('message', 'Post deleted successfully');
    }
} 