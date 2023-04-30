<?php

class Order extends Model
{
    public function getAllOrders()
    {
        $this->db->query('SELECT * FROM orders');
        return $this->db->resultSet();
    }

    public function getAllOrdersWithUsers()
    {
        $this->db->query('SELECT orders.*, users.name as user_name FROM orders INNER JOIN users ON orders.user_id = users.id');
        $orders = $this->db->resultSet();
        $orders_ids = array_map(function ($order) {
            return $order->id;
        }, $orders);
        // convert $orders_ids to string that accepted in IN clause
        $orders_ids = implode(',', $orders_ids);
        $this->db->query('SELECT * FROM orders_product where order_id IN (:orders_ids)');
        $this->db->bind(':orders_ids', $orders_ids);
        $orders_products = $this->db->resultSet();
        foreach ($orders as $order) {
            $order->products = array_filter($orders_products, function ($order_product) use ($order) {
                return $order_product->order_id == $order->id;
            });
        }
        return $orders;
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
}
