<?php

class Checks extends Controller
{
    private $orderModel;
    private $productModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('/users/login');
        }
        $this->orderModel = $this->model('Order');
        $this->productModel = $this->model('Product');
    }

    public function index()
    {

        $startDate = 0;
        $endDate = time();
        $data = [
            "orders" => $this->orderModel->getAllOrdersWithUsers($startDate, $endDate),
            'products' => $this->productModel->getProducts(),
        ];


        return $this->view('checks/index', $data);
    }
}