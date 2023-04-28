<?php

class Users extends Controller
{
    public function __construct()
    {
//        if(isLoggedIn())
//        {
//            redirect('home');
//        }
        $this->userModel = $this->model('User');
    }

    public function cccc(){
        $data =  $this->userModel->getUsers();
        return $this->view('users/index', $data);
    }

    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'name'		=>	trim($_POST['name']),
                'email'		=>	trim($_POST['email']),
                'password'	=>	trim($_POST['password']),
                'confirm_password'	=>	trim($_POST['confirm_password']),
                'name_error'		=>	'',
                'email_error'		=>	'',
                'password_error'	=>	'',
                'confirm_password_err' => ''
            ];

            if(empty($data['email']))
            {
                $data['email_err'] = 'Please enter email';
            }
            else
            {
                if($this->userModel->findUserByEmail($data['email']))
                {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            if(empty($data['name']))
            {
                $data['name_err'] = 'Please enter a name';
            }

            if(empty($data['password']))
            {
                $data['password_err'] = 'Please enter a password';
            } elseif(strlen($data['password']) < 6)
            {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if(empty($data['confirm_password']))
            {
                $data['confirm_password_err'] = 'Please confirm password';
            }
            else
            {
                if($data['password'] != $data['confirm_password'])
                {
                    $data['confirm_password_err'] = 'Passwords does not match';
                }
            }

            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
            {
                if($this->userModel->register($data))
                {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                }
                else
                {
                    die('Something went wrong');
                }
            }
            else
            {
                $this->view('users/register', $data);
            }
        }
        else
        {
            $data = [
                'name'		=>	'',
                'email'		=>	'',
                'password'	=>	'',
                'confirm_password'	=>	'',
                'name_error'		=>	'',
                'email_error'		=>	'',
                'password_error'	=>	'',
                'confirm_password_err' => ''
            ];

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $data = [
                'email'		=>	trim($_POST['email']),
                'password'	=>	trim($_POST['password']),
                'email_error'		=>	'',
                'password_error'	=>	'',
            ];

            if(empty($data['email']))
            {
                $data['email_err'] = 'Please enter email';
            }

            if(empty($data['password']))
            {
                $data['password_err'] = 'Please enter password';
            }

            if(!$this->userModel->findUserByEmail($data['email']))
            {
                $data['email_err'] = 'No user found';
            }

            if(empty($data['email_err']) && empty($data['password_err']))
            {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if(!$loggedInUser)
                {
                    $data['password_err'] = 'Password Incorrect';
                    $this->view('users/login', $data);
                }
            }
            else
            {
                $this->view('users/login', $data);
            }
        }
        else
        {
            $data = [
                'email'		=>	'',
                'password'	=>	'',
                'email_error'		=>	'',
                'password_error'	=>	''

            ];

            $this->view('users/login', $data);
        }
    }

    public function logout(){
        logoutSession();
    }

}
