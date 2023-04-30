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

    public function deliver()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order = $this->orderModel->find($_POST['id']);
            if ($order) {
                $data = ['id' => $_POST['id']];
                if ($order->status === "Processing") {
                    $data['status'] = 'out for delivery';
                } else if ($order->status === "out for delivery") {
                    $data['status'] = 'done';
                }
                $data = $this->orderModel->changeStatus($data);
                if ($data) {
                    flash('order_message', "Status Changed Successfuly", 'success');
                    return redirect('orders');
                }
            } else {
                flash('order_message', 'Order Not Found', 'danger');
                return redirect('orders');
            }
        }
    }
}
