<?php

class Orders extends Controller
{
    private $userModel;
    private $orderModel;
    private $productModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->orderModel = $this->model('Order');
        $this->productModel = $this->model('Product');
    }

    public function index()
    {
        $data = [
            "orders" => $this->orderModel->getAllOrdersWithUsers(),
            'products' => $this->productModel->getProducts(),
        ];

        return $this->view('orders/index', $data);
    }

    public function create()
    {
        $data = [
            "products" => $this->productModel->getProducts(),
            "user_last_orders" => [],
            "users" => []
        ];
        $_SESSION['role'] = 'Admin';
        if ($_SESSION && $_SESSION['role'] == 'Admin') {
            $data['users'] = $this->userModel->getUsersByRole('User');
        }
        /*$db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 5');
        $db->bind(':user_id', $_SESSION['user_id']);
        $data['user_last_orders'] = $db->resultSet();*/

        return $this->view('orders/create', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            print_r($_POST);
            $data = [
                'user_id' => $_POST['user_id'],
                'products' => $_POST['products'],
                'room' => $_POST['room'],
                'note' => $_POST['note'],
            ];
            $_POST['status'] = 'success';
            $data = json_encode($_POST);
            die($data);
        }
    }
}