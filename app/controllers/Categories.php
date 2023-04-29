<?php

class Categories extends Controller
{
    public $categoryModel;

    public function __construct()
    {
        //        if(isLoggedIn())
        //        {
        //            redirect('home');
        //        }
        $this->categoryModel = $this->model('Category');
    }

    public function index()
    {
        $data =  $this->categoryModel->getCategories();
        return $this->view('categories/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name'        =>    trim($_POST['name']),
                'name_error'        =>    '',
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            } else {
                $this->categoryModel->addCategory($data);
                return redirect('categories');
            }
        } else {
            $data = [
                'name'        =>    '',
            ];
            $this->view('categories/create', $data);
        }
    }


    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category = $this->categoryModel->find($_POST['id']);
            if ($category) {
                $this->categoryModel->deleteCategory($_POST['id']);
                return redirect('categories');
            }
        }
    }
}
