<?php

class Order extends Model
{
    public function getAllOrders()
    {
        $this->db->query('SELECT * FROM orders');
        return $this->db->resultSet();
    }

    public function getAllOrdersWithUsers($start = 0, $end = 0)
    {

        $this->db->query('SELECT orders.*, users.name as user_name FROM orders INNER JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC');
        $orders = $this->db->resultSet();
        $orders_ids = array_map(function ($order) use ($start, $end) {
//            if ($order->date >= $start && $order->date <= $end) {
            return $order->id;
//            }
        }, $orders);

        $this->db->query('SELECT * FROM orders_product where order_id IN ( ' . implode(',', $orders_ids) . ' )');
        $orders_products = $this->db->resultSet();
        foreach ($orders as $order) {
            $order->products = array_filter($orders_products, function ($order_product) use ($order) {
                return $order_product->order_id == $order->id;
            });
        }
        return $orders;
    }

    public function changeStatus($data)
    {
        $this->db->query('UPDATE orders SET status = :status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':status', $data['status']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductsPrices($array)
    {
        $this->db->query('SELECT * FROM product WHERE id IN (' . implode(',', $array) . ')');
        return $this->db->resultSet();
    }

    public function find($id)
    {
        $this->db->query('SELECT * FROM orders WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM orders WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function addOrder($data)
    {
        $this->db->query('INSERT INTO orders (user_id, price, note) VALUES (:user_id, :total_price, :note)');
        $this->db->bind(':user_id', $data->user_id);
        $this->db->bind(':total_price', $data->price);
        $this->db->bind(':note', $data->note);
        $this->db->execute();
        $order_id = $this->db->lastInsertId();
        $this->db->query('INSERT INTO orders_product (order_id, product_id, quantity,price) VALUES (:order_id, :product_id, :quantity, :price)');
        foreach ($data->products as $product) {
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':product_id', $product->id);
            $this->db->bind(':quantity', $product->quantity);
            $this->db->bind(':price', $product->price);
            $this->db->execute();
        }
        return $order_id;
    }

}