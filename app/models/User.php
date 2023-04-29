<?php

class User extends Model
{
    public function getUsers()
    {
        $this->db->query('SELECT * FROM users');
        return $this->db->resultSet();
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

    public function addUser($data)
    {
        $errors =$this->validateCreation($data);
        if (count($errors) > 0) {
            return $errors;
        }
        $this->db->query('INSERT INTO users (name, email, pass,avatar,role) VALUES (:name, :email, :password,:avatar,:role)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':avatar', $data['avatar']);
        $this->db->bind(':role', $data['role']);
        return $this->db->execute();
    }

    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            createUserSession($row);
            return true;
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function deleteUserById($id)
    {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function updateUser($data)
    {
        $errors = $this->validateUpdate($data);
        if (count($errors) > 0) {
            return $errors;
        }
        $user = $this->find($data['id']);
        $this->db->query('UPDATE users SET name = :name, email = :email, pass = :password, avatar = :avatar, role = :role WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name'] || $user->name);
        $this->db->bind(':email', $data['email'] || $user->email);
        $this->db->bind(':password', $data['password']?password_hash($data['password'], PASSWORD_DEFAULT):$user->password);
        $this->db->bind(':avatar', $data['avatar'] || $user->avatar);
        $this->db->bind(':role', $data['role']|| $user->role);
        return $this->db->execute();
    }


    public function getUserByRole($role)
    {
        $this->db->query('SELECT * FROM users WHERE role = :role');
        $this->db->bind(':role', $role);
        return $this->db->resultSet();
    }


    private function validateCreation($data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Please enter name';
        }else{
            if(strlen($data['name']) < 3){
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Please enter email';
        }elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
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
            }elseif (!preg_match("#[0-9]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 number';
            }elseif (!preg_match("#[A-Z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 capital letter';
            }elseif (!preg_match("#[a-z]+#", $data['password'])) {
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

        if (empty($data['role'])) {
            $errors['role'] = 'Please enter role';
        }else{
            if($data['role'] != 'Admin' && $data['role'] != 'User'){
                $errors['role'] = 'Role must be admin or user';
            }
        }

        return $errors;
    }

    private function validateUpdate($data){
        $errors = [];
        if (!empty($data['name'])) {
            if(strlen($data['name']) < 3){
                $errors['name'] = 'Name must be at least 3 characters';
            }
        }
        if (!empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter the correct email format';
            } else {
                if ($this->findUserByEmail($data['email'])) {
                    $errors['email'] = 'Email is already taken';
                }
            }
        }
        if (!empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }elseif (!preg_match("#[0-9]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 number';
            }elseif (!preg_match("#[A-Z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 capital letter';
            }elseif (!preg_match("#[a-z]+#", $data['password'])) {
                $errors['password'] = 'Password must contain at least 1 lowercase letter';
            }
        }
        if (!empty($data['confirm_password'])) {
            if ($data['password'] != $data['confirm_password']) {
                $errors['confirm_password'] = 'Passwords do not match';
            }
        }

        if (!empty($data['role'])) {
            if($data['role'] != 'Admin' && $data['role'] != 'User'){
                $errors['role'] = 'Role must be admin or user';
            }
        }


        return $errors;
    }


}