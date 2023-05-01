<?php

class Checks extends Controller
{
    private $orderModel;
    private $productModel;

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
        $this->productModel = $this->model('Product');
    }

    public function index()
    {
        $data = [
            "orders" => $this->orderModel->getAllOrdersWithUsers(),
            'products' => $this->productModel->getProducts(),
        ];

        return $this->view('checks/index', $data);
    }
}