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
        $request_data = $errors = [
            'name' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // update request data
            $request_data = array_merge($request_data, $_POST);
            $errs = $this->categoryModel->addCategory($request_data);
            if (is_array($errs)) {
                $errors = array_merge($errors, $errs);
            } else {
                if ($errs === true) {
                    flash('category_message', 'Category added', 'success');
                    return redirect('categories/index');
                } else {
                    flash('category_message', 'Something went wrong', 'danger');
                }
            }
        }

        $data = [
            'errors' => $errors,
            'data' => $request_data,
        ];

        return $this->view('categories/create', $data);
    }


    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category = $this->categoryModel->find($_POST['id']);
            if ($category) {
                $data =  $this->categoryModel->deleteCategory($_POST['id']);
                if ($data) {
                    flash('category_message', 'Category Deleted', 'success');
                } else {
                    flash('category_message', 'Something went wrong', 'danger');
                }
                return redirect('categories');
            } else {
                flash('category_message', 'Category Not Found', 'danger');
                return redirect('categories');
            }
        }
    }

    public function update($id)
    {

        $request_data = $errors = [
            'name' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // update request data
            $request_data = array_merge($request_data, $_POST);
            $errs = $this->categoryModel->updateCategory($request_data);
            if (is_array($errs)) {
                $errors = array_merge($errors, $errs);
            } else {
                if ($errs === true) {
                    flash('category_message', 'Category Updated', 'success');
                    return redirect('categories/index');
                } else {
                    flash('category_message', 'Something went wrong', 'danger');
                }
            }
        }
        $data = [
            'errors' => $errors,
            'data' => $request_data,
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'errors' => [
                    'name' => '',
                ],
                'data' => []
            ];
            $data['data'] = $this->categoryModel->getCategoryById($id);
        }
        return $this->view('categories/update', $data);
    }
}