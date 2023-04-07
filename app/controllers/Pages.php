<?php

class Pages extends Controller
{
    public function __construct()
    {
        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        $data = [
            'title' => 'Welcome'
        ];
        $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Page'
        ];
        $this->view('pages/index', $data);
    }

    public function page404()
    {
        $data = [
            'title' => '404 Page Not Found'
        ];
        $this->view('pages/404', $data);
    }

    public function page500()
    {
        $data = [
            'title' => '500 Internal Server Error'
        ];
        $this->view('pages/500', $data);
    }
}