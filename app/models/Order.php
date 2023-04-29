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


}