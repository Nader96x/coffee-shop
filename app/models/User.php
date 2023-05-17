<?php

class User extends Model
{
    public function getUsers()
    {
        $this->db->query('SELECT * FROM users');
        return $this->db->resultSet();
    }

    public function addUser($data)
    {

        $errors = $this->validateCreation($data);
        $image_data = $this->prepareImage();
        $errors = array_merge($errors, $image_data[0]);
        $data = array_merge($data, $image_data[1]);
//        die(print_r($errors) . print_r($data));
        if (count($errors) > 0) {
//            die(print_r($errors));
            return $errors;
        }
        $this->db->query('INSERT INTO users (name, email, pass,avatar,role) VALUES (:name, :email, :password,:avatar,:role)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':avatar', $data['avatar']);
        $this->db->bind(':role', in_array('role', array_keys($data)) ? $data['role'] : 'User');
        return $this->db->execute();
    }

    private function validateCreation($data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Please enter name';
        } else {
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Please enter email';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter the correct email format';
        } else {
            if ($this->findUserByEmail($data['email'])) {
                $errors['email'] = 'Email is already taken';
            }
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Please enter password';
        } else {
            if (strlen($data['password']) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            } elseif (!preg_match("#[0-9]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 number';
            } elseif (!preg_match("#[A-Z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 capital letter';
            } elseif (!preg_match("#[a-z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 lowercase letter';
            }
        }
        if (empty($data['confirm_password'])) {
            $errors['confirm_password'] = 'Please confirm password';
        } else {
            if ($data['password'] != $data['confirm_password']) {
                $errors['confirm_password'] = 'Passwords do not match';
            }
        }

        if (empty($data['avatar'])) {
            $errors['avatar'] = 'Please enter avatar';
        }

        if (!empty($data['role'])) {
            if ($data['role'] != 'Admin' && $data['role'] != 'User') {
                $errors['role'] = 'Role must be admin or user';
            }
        }
//        die(print_r($errors) . print_r($data));
        return $errors;
    }

    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function prepareImage()
    {
        $errors = [];
        $data = [];
        if (empty($_FILES['avatar']['name']) || $_FILES['avatar']['size'] == 0)
            $errors['avatar'] = "photo is required.";
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

    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        $hashed_password = $row->pass;
        if (password_verify($password, $hashed_password)) {
            createUserSession($row);
            return true;
        } else {
            return false;
        }
    }

    public function deleteUserById($id)
    {
        $user = $this->find($id);
        if ($user->avatar != URLROOT . '/uploads/default.png') {
            unlink($user->avatar);
        }
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function find($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateUser($data)
    {
        $errors = $this->validateUpdate($data);
        if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['size'] > 0) {
            $image_data = $this->prepareImage();
            $errors = array_merge($errors, $image_data[0]);
            $data = array_merge($data, $image_data[1]);
        }

        if (count($errors) > 0) {
            return $errors;
        }
        $user = $this->find($data['id']);
        $this->db->query('UPDATE users SET name = :name, email = :email, pass = :password, avatar = :avatar WHERE id = :id');
        $this->db->bind(':id', $user->id);
        $this->db->bind(':name', in_array('name', array_keys($data)) ? $data['name'] : $user->name);
        $this->db->bind(':email', in_array('email', array_keys($data)) ? $data['email'] : $user->email);
        $this->db->bind(':password', in_array('password', array_keys($data)) ? password_hash($data['password'], PASSWORD_DEFAULT) : $user->pass);
        $this->db->bind(':avatar', in_array('avatar', array_keys($data)) ? $data['avatar'] : $user->avatar);

        $result = $this->db->execute();
        if ($result) {
            if ($user->avatar != URLROOT . '/uploads/default.png' && in_array('avatar', array_keys($data))) {
                unlink($user->avatar);
            }
            return true;
        }
        return false;
    }

    private function validateUpdate($data)
    {
        $errors = [];
        if (!empty($data['name'])) {
            if (strlen($data['name']) < 3) {
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (!empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter the correct email format';
            } else {
                if ($this->findUserByEmail($data['email']) && $data['email'] != $this->getUserByID($data['id'])->email) {
                    $errors['email'] = 'Email is already taken';
                }
            }
        }
        if (!empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            } elseif (!preg_match("#[0-9]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 number';
            } elseif (!preg_match("#[A-Z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 capital letter';
            } elseif (!preg_match("#[a-z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 lowercase letter';
            }
        }
        if (!empty($data['confirm_password'])) {
            if ($data['password'] != $data['confirm_password']) {
                $errors['confirm_password'] = 'Passwords do not match';
            }
        }

        return $errors;
    }

    public function getUserByID($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getUsersByRole($role)
    {
        $this->db->query('SELECT * FROM users WHERE role = :role');
        $this->db->bind(':role', $role);
        return $this->db->resultSet();
    }

    public function getUserLastOrdersItems($id, $limit = 5)
    {
        $this->db->query('SELECT id FROM orders WHERE user_id = :id ORDER BY date DESC LIMIT :limit');
        $this->db->bind(':id', $id);
        $this->db->bind(':limit', $limit);
        $orders = $this->db->resultSet();
        $items = [];
        foreach ($orders as $order) {
            $this->db->query('SELECT product_id FROM orders_product WHERE order_id = :id');
            $this->db->bind(':id', $order->id);
            $items = array_merge($items, $this->db->resultSet());
        }
        $items = array_map(function ($item) {
            return $item->product_id;
        }, $items);
        $this->db->query('SELECT * FROM product WHERE id IN (' . implode(',', $items) . ')');
        $products = $this->db->resultSet();
        return $products;
    }

}