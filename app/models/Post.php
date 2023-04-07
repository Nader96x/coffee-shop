<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPosts()
    {
        $this->db->query('SELECT *, posts.id as id, users.id as user_id FROM posts JOIN users ON posts.user_id = users.id');
        return $this->db->resultSet();
    }

    public function getPostById($id)
    {
        $this->db->query('SELECT *, posts.id as id, users.id as user_id FROM posts join users on posts.user_id = users.id WHERE posts.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->db->query('UPDATE posts SET title = :title, body = :body, user_id = :user_id WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function countPosts()
    {
        $this->db->query('SELECT COUNT(*) FROM posts');
        return $this->db->single();
    }

    public function searchPosts($data)
    {
        $this->db->query('SELECT * FROM posts WHERE title LIKE :title');
        $this->db->bind(':title', $data['title']);
        return $this->db->resultSet();
    }

    public function getPostsByUser($user_id)
    {
        $this->db->query('SELECT * FROM posts WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

}

