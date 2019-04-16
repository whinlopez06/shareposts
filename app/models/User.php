<?php 

class User {

    private $db;
    private $table_name = 'users';
    // edl added
    private $_isLoggedIn;
    private $_data;
    

    public function __construct(){
    
        $this->db = new Database();
    }

    public function register($data = []){
        $this->db->query('INSERT INTO ' . $this->table_name . ' SET name = :name, email = :email, password = :password ');
        // Bind Values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        
        // Execute
        if($this->db->execute()){
            return true;
        }

        return false;
    }


    // Login User
    public function login($email, $password){
        $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->_data = $this->db->single(); // get single row and store object result to _data var

        // compare the password stored in db to password prevoided then using password verify to compare
        $hashed_password = $this->_data->password;
        if(password_verify($password, $hashed_password)){
            // return $this->_data or the result from single
            return true;
        }

        return false;
    }

    // Find user by Email
    //--public function findUserByEmail($email){
    public function userEmailExists($email){

        $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // check row
        if($this->db->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function getUserById($id){
        $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE id = :id ');
        $this->db->bind(':id', $id);

        $this->_data = $this->db->single();

        return $this->data();
    }   

    //edl added: return instance of object from db and  store in data variable
    public function data(){
        return $this->_data;
    } 
    

}

?>