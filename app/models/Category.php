<?php

class Category extends Model
{
    public function getCategories()
    {
        $this->db->query('SELECT * FROM category');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getCategoryById($id)
    {
        $this->db->query('SELECT * FROM category WHERE id = :id');
        $this->db->bind(':id', $id);
        $results = $this->db->single();
        return $results;
    }

    public function addCategory($data)
    {
        $this->db->query('INSERT INTO category (name) VALUES (:name)');
        $this->db->bind(':name', $data['name']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCategory($data)
    {
        $this->db->query('UPDATE category SET name = :name WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCategory($id)
    {
        $this->db->query('DELETE FROM category WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCategoryProducts($id)
    {
        $this->db->query('SELECT * FROM product WHERE cat_id = :id');
        $this->db->bind(':id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    public function categoryExists($name)
    {
        $this->db->query('SELECT * FROM category WHERE name = :name');
        $this->db->bind(':name', $name);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private  function validateCreate($data)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Please enter a name';
        }else{
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }elseif (strlen($data['name']) > 255) {
                $errors['name'] = 'Name must be less than 255 characters';
            }elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $data['name'])) {
                $errors['name'] = 'Name can only contain letters, numbers and spaces';
            }elseif ($this->categoryExists($data['name'])) {
                $errors['name'] = 'Name is already taken';
            }
        }
        return $errors;
    }

    private function validateUpdate($data){
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Please enter a name';
        }else{
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }elseif (strlen($data['name']) > 255) {
                $errors['name'] = 'Name must be less than 255 characters';
            }elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $data['name'])) {
                $errors['name'] = 'Name can only contain letters, numbers and spaces';
            }elseif ($this->categoryExists($data['name']) && $data['name'] != $this->getCategoryById($data['id'])->name) {
                $errors['name'] = 'Name is already taken';
            }
        }
        return $errors;
    }

}