<?php

class Post {

    private $db;
    private $table_name = 'posts';
    private $_data;


    public function __construct(){
        $this->db = new Database();
    }

    public function getPosts(){
        $this->db->query('SELECT * FROM posts');

        $results = $this->db->resultSet();  // return morethan one row
        
        return $results;
    }

    public function getPostsWithUser(){
        $this->db->query('SELECT posts.title, posts.body, posts.created_at,users.name, 
                        posts.id as postId, users.id as userId 
                        FROM posts INNER JOIN users ON posts.user_id = users.id
                        ORDER by posts.created_at DESC ');

        $results = $this->db->resultSet();    

        return $results;
    }

    public function getPostById($id){
        $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE id = :id ');
        $this->db->bind(':id', $id);

        $this->_data = $this->db->single(); // get single data

        return $this->data();
    }

    public function addPost($data = []){
        $this->db->query('INSERT INTO ' . $this->table_name . ' SET title = :title, body = :body, user_id = :user_id');
        //Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute
        if($this->db->execute()){
            //$this->_data = $this->db->stmt;
            return true;
        }

        return false;
    }

    public function updatePost($data = []){
        $this->db->query('UPDATE ' . $this->table_name . ' SET title = :title, body = :body WHERE id = :id ');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':id', $data['id']);
        
        //Execute
        if($this->db->execute()){
            //$this->_data = $this->db->stmt;
            return true;
        }

        return false;
    }

    public function deletePost($id){
        $this->db->query('DELETE FROM ' . $this->table_name . ' WHERE id = :id ');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        }

        return false;
    }

    public function data(){
        return $this->_data;
    }
}

?>