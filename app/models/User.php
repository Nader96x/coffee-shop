<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

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

    public function register($data)
    {
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
        $user = $this->find($data['id']);
        $this->db->query('UPDATE users SET name = :name, email = :email, pass = :password, avatar = :avatar, role = :role WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name'] || $user->name);
        $this->db->bind(':email', $data['email'] || $user->email);
        $this->db->bind(':password', $data['password'] ? password_hash($data['password'], PASSWORD_DEFAULT) : $user->password);
        $this->db->bind(':avatar', $data['avatar'] || $user->avatar);
        $this->db->bind(':role', $data['role'] || $user->role);
        return $this->db->execute();
    }


    public function getUserByRole($role)
    {
        $this->db->query('SELECT * FROM users WHERE role = :role');
        $this->db->bind(':role', $role);
        return $this->db->resultSet();
    }
}
