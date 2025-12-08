<?php

namespace App\Controllers;

use App\Models\BlogPostModel;
use App\Models\CommentModel;

class HomeController extends BaseController
{
    protected $blogPostModel;
    protected $commentModel;

    public function __construct()
    {
        $this->blogPostModel = new BlogPostModel();
        $this->commentModel = new CommentModel();
    }

    public function index()
    {
        $data['posts'] = $this->blogPostModel->orderBy('created_at', 'DESC')->findAll();
        return view('home/index', $data);
    }

    public function show($id)
    {
        $data['post'] = $this->blogPostModel->find($id);
        
        if (!$data['post']) {
            return redirect()->to('/')->with('error', 'Blog post not found');
        }

        // Get comments for this post
        $data['comments'] = $this->commentModel->where('post_id', $id)
                                              ->orderBy('created_at', 'DESC')
                                              ->findAll();

        return view('home/show', $data);
    }

    public function addComment()
    {
        $rules = [
            'post_id' => 'required|numeric',
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'comment' => 'required|min_length[3]|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'post_id' => $this->request->getPost('post_id'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'comment' => $this->request->getPost('comment')
        ];

        $this->commentModel->insert($data);
        return redirect()->back()->with('message', 'Comment added successfully');
    }
} 