<?php
require_once('../app/models/Category.php');

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

    public function find($id)
    {
        $this->db->query('SELECT * FROM product WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addProduct($data)
    {
        $errors = $this->validateCreate($data);
        $image_data = $this->prepareImage();
        $errors = array_merge($errors, $image_data[0]);
        $data = array_merge($data, $image_data[1]);
        if (count($errors) > 0) {
            return $errors;
        }
        $this->db->query('INSERT INTO product (name, price, status, cat_id, avatar) VALUES (:name, :price, :status, :cat_id, :avatar)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':cat_id', $data['cat_id']);
        $this->db->bind(':avatar', $data['avatar']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($data)
    {
        $errors = $this->validateUpdate($data);
        if (!empty($errors)) {
            return $errors;
        }
        $this->db->query('UPDATE product SET name = :name, price = :price, image = :image, status = :status, cat_id = :cat_id WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':cat_id', $data['cat_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($id): bool
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
        $this->db->query('SELECT * FROM product WHERE cat_id = :category_id');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    private function validateCreate($data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        } else {
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (empty($data['price'])) {
            $errors['price'] = 'Price is required';
        } else {
            if (!is_numeric($data['price'])) {
                $errors['price'] = 'Price must be a number';
            } elseif ($data['price'] < 0) {
                $errors['price'] = 'Price must be a positive number';
            }
        }
        if (empty($data['avatar'])) {
            $errors['avatar'] = 'aa is required';
        }
        if (empty($data['status']) && $data['status'] != 0) {
            $errors['status'] = 'status is required';
        }
        if (empty($data['cat_id'])) {
            $errors['cat_id'] = 'Category is required';
        } else {
            if ($this->category->getCategoryById($data['cat_id']) == null) {
                $errors['cat_id'] = 'Category does not exist';
            }
        }
        return $errors;
    }

    private function validateUpdate($data): array
    {
        $errors = [];
        if (empty($data['id'])) {
            $errors['id'] = 'Id is required';
        } else {
            if (!is_int($data['id'])) {
                $errors['id'] = 'Id must be a number';
            } elseif ($this->getProductById($data['id']) == null) {
                $errors['id'] = 'Product does not exist';
            }
        }
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        } else {
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (empty($data['price'])) {
            $errors['price'] = 'Price is required';
        } else {
            if (!is_float($data['price'])) {
                $errors['price'] = 'Price must be a number';
            } elseif ($data['price'] < 0) {
                $errors['price'] = 'Price must be a positive number';
            }
        }
        if (empty($data['image'])) {
            $errors['image'] = 'Image is required';
        }
        if (empty($data['status'])) {
            $errors['status'] = 'status is required';
        }
        if (empty($data['cat_id'])) {
            $errors['cat_id'] = 'Category is required';
        } else {
            if ($this->category->getCategoryById($data['cat_id']) == null) {
                $errors['cat_id'] = 'Category does not exist';
            }
        }
        return $errors;
    }

    private function prepareImage()
    {
        $errors = [];
        $data = [];
        if (empty($_FILES['avatar']['name']) || $_FILES['avatar']['size'] == 0)
            $errors['avatar'] = "photo is required";
        else {

            $allowedTypes = ["image/png", "image/jpg", "image/jpeg", "image/gif"];
            if (!in_array($_FILES['avatar']['type'], $allowedTypes))
                $errors['avatar'] = "photo is required and must be png, jpg, gif or jpeg";
            else {
                $photo = $_FILES['avatar']['name'];
                $tmp = $_FILES['avatar']['tmp_name'];
                if (!is_dir("uploads"))
                    mkdir("uploads");
                $photo = "uploads/" . uniqid() . "_" . $photo;
                move_uploaded_file($tmp, $photo);
                $data['avatar'] = URLROOT . '/' . $photo;
            }
        }

        return [$errors, $data];
    }
}
