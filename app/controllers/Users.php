<?php

class Users extends Controller
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        if (isLoggedIn()) {
            redirect('orders');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'No user found';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if (!$loggedInUser) {
                    $data['password_err'] = 'Password Incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => ''

            ];

            $this->view('users/login', $data);
        }
    }

    public function logout()
    {
        logoutSession();
    }

    public function index()
    {
        if (!isLoggedIn() || !isAdmin()) {
            redirect('users/login');
        }
        $data = $this->userModel->getUsersByRole("User");
        return $this->view('users/index', $data);
    }

    public function indexAdmin()
    {
        $data = $this->userModel->getUsersByRole("Admin");
        return $this->view('users/indexAdmin', $data);
    }

    public function create()
    {
        if (!isLoggedIn() || !isAdmin()) {
            redirect('users/login');
        }
        $request_data = $errors = [
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'avatar' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // update request data
            $request_data = array_merge($request_data, $_POST);
            $request_data['avatar'] = $_FILES['avatar']['name'];
            $errs = $this->userModel->addUser($request_data);
            if (is_array($errs)) {
                $errors = array_merge($errors, $errs);
            } else {
                if ($errs === true) {
                    flash('user_message', 'User added', 'success');
                    return redirect('users/index');
                } else {
                    flash('user_message', 'Something went wrong', 'danger');
                }
            }
        }

        $data = [
            'errors' => $errors,
            'data' => $request_data,
        ];

        return $this->view('users/create', $data);
    }

    public function edit($id)
    {
        if (!isLoggedIn() || !isAdmin()) {
            redirect('users/login');
        }
        $request_data = $errors = [
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'avatar' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // update request data
            $request_data = array_merge($request_data, $_POST);
            $request_data['avatar'] = $_FILES['avatar']['name'];
            $errs = $this->userModel->updateUser($request_data);
            if (is_array($errs)) {
                $errors = array_merge($errors, $errs);
            } else {
                if ($errs === true) {
                    flash('user_message', 'User Edited', 'success');
                    return redirect('users/index');
                } else {
                    flash('user_message', 'Something went wrong', 'danger');
                }
            }


        }
        $data = [
            'errors' => $errors,
            'data' => $request_data,
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = ['errors' => [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'avatar' => '',
            ],
                'data' => []
            ];
            $data['data'] = $this->userModel->getUserById($id);
        }

//        die(var_dump($data));
        return $this->view('users/edit', $data);
    }


    public function delete($id)
    {
        if (!isLoggedIn() || !isAdmin()) {
            redirect('users/login');
        }
        $data = $this->userModel->deleteUserById($id);
        flash('user_message', 'User deleted');
        redirect('users/index');
    }
}
