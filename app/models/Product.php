<?php

class Product extends Model
{

    private $category;
    public function __construct()
    {
        parent::__construct();
        $this->category = new Category;
    }

    public function getProducts()
    {
        $this->db->query('SELECT * FROM product');
        return $this->db->resultSet();
    }

    public function getProductById($id)
    {
        $this->db->query('SELECT * FROM product WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addProduct($data)
    {
        $this->db->query('INSERT INTO product (name, price, image, description, category_id) VALUES (:name, :price, :image, :description, :category_id)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($data)
    {
        $this->db->query('UPDATE product SET name = :name, price = :price, image = :image, description = :description, category_id = :category_id WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($id)
    {
        $this->db->query('DELETE FROM product WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductsByCategory($category_id)
    {
        $this->db->query('SELECT * FROM product WHERE category_id = :category_id');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    private function validateCreate($data): array{
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }else{
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (empty($data['price'])) {
            $errors['price'] = 'Price is required';
        }else{
            if (!is_float($data['price'])) {
                $errors['price'] = 'Price must be a number';
            }elseif ($data['price'] < 0){
                $errors['price'] = 'Price must be a positive number';
            }
        }
        if (empty($data['image'])) {
            $errors['image'] = 'Image is required';
        }
        if (empty($data['description'])) {
            $errors['description'] = 'Description is required';
        }else{
            if (strlen($data['description']) < 10) {
                $errors['description'] = 'Description must be at least 10 characters';
            }
        }
        if (empty($data['category_id'])) {
            $errors['category_id'] = 'Category is required';
        }else{
            if (!is_int($data['category_id'])) {
                $errors['category_id'] = 'Category must be a number';
            }elseif ($this->category->getCategoryById($data['category_id']) == null){
                $errors['category_id'] = 'Category does not exist';
            }
        }
        return $errors;
    }
}