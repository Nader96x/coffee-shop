<?php

class Products extends Controller
{
    public $productModel;

    public function __construct()
    {
        //        if(isLoggedIn())
        //        {
        //            redirect('home');
        //        }
        $this->productModel = $this->model('Product');
    }

    public function index()
    {
        $data =  $this->productModel->getProducts();
        return $this->view('products/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name'        =>    trim($_POST['name']),
                'price'        =>    trim($_POST['price']),
                'image'    =>    trim($_POST['image']),
                'status'    =>    trim($_POST['status']),
                'cat_id'    =>    trim($_POST['cat_id']),
                'name_error'        =>    '',
                'price_error'        =>    '',
                'image_error'    =>    '',
                'status_error' => '',
                'cat_id_error' => ''
            ];

            if (empty($data['price'])) {
                $data['price_error'] = 'Please enter Product price';
            } else {
                if ($this->productModel->findUserByEmail($data['email'])) {
                    $data['price_error'] = 'Email is already taken';
                }
            }

            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter a name';
            }

            if (empty($data['password'])) {
                $data['price_error'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['price_error'] = 'Password must be at least 6 characters';
            }


            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                if ($this->productModel->register($data)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('products/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('products/register', $data);
            }
        } else {
            $data = [
                'name'        =>    '',
                'email'        =>    '',
                'password'    =>    '',
                'confirm_password'    =>    '',
                'name_error'        =>    '',
                'email_error'        =>    '',
                'password_error'    =>    '',
                'confirm_password_err' => ''
            ];

            $this->view('products/register', $data);
        }
    }
}
