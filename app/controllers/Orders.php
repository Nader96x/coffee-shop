<?php

class Orders extends Controller
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $data = [
            "products" => [],
            "user_last_orders" => [],
            "users" => []
        ];
        $db = new Database();
        /*$db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 5');
        $db->bind(':user_id', $_SESSION['user_id']);
        $data['user_last_orders'] = $db->resultSet();*/
        $db->query('SELECT * FROM product');
        $data['products'] = $db->resultSet();

        $data['users'] = $this->userModel->getUsersByRole('User');

        return $this->view('orders/index', $data);
    }

    public function create()
    {
        $data = [
            "products" => [],
            "user_last_orders" => [],
            "users" => []
        ];
        $db = new Database();
        /*$db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 5');
        $db->bind(':user_id', $_SESSION['user_id']);
        $data['user_last_orders'] = $db->resultSet();*/
        $db->query('SELECT * FROM product');
        $data['products'] = $db->resultSet();
        $data['users'] = $this->userModel->getUsersByRole('User');

        return $this->view('orders/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['status'] = 'success';
            $data = json_encode($_POST);
            die($data);
        }
    }
}