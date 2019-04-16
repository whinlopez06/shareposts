<?php

// in laravel using just import the model clss with namespace here

class UsersController extends Controller {

    public function __construct()
    {
        // Init model class
        $this->userModel = $this->model('User');    // base controller will require the class and return Instantiate of that class
    }

    public function register(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD']  == 'POST'){
            // Process form


            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = $_POST;
            // include the input error field
            $data = array_merge($data, array('name_err' => ''), array('email_err' => ''), array('password_err' => ''), array('password_confirm_err' => ''));
            
            // Init validate class
            $validate = new Validate();
            //print_r($validate); die();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 3
                ),
                'email' => array(
                    'required' => true,
                    'min' => 6,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' =>true,
                    'min' => 4
                ),
                'confirm_password' => array(
                    'required' => true,
                    'matches' => 'password'
                )
            ));

            if($validation->passed()){
                // Hash Password (one way hashing)
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); 
                // register the user
                if($this->userModel->register($data)){
                    // Redirect to login
                    //header('Location: ' . URLROOT . '/users/login');
                    Session::flash('login', 'You are registered and can now log in!');
                    Session::flash('login_class', 'alert alert-success');

                    redirect('users/login');    // helper function redirect
                }else{
                    die('Something went wrong');
                }
            }else{
                foreach($validation->errors() as $error => $error_values){
                    foreach($error_values as $value => $val){
                        $data[$value] = $error_values[$value];
                         //$data[array_keys($error_values)[0]] = array_values($error_values)[0]; 
                    }    
                }
                $this->view('Users/Register', $data);
            }
            
            /*
            // Init Data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'pass_err' => '',
                'confirm_password_err' => ''
            ]; */


        }else{
            // Init Data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'pass_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view 
            $this->view('users/register', $data);
        }
    }

    public function login(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD']  == 'POST'){
            // Process form

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
            $data = $_POST;
            
            $data = array_merge($data, array('email_err' => ''), array('password_err' => ''));
            
            $validate = new Validate();
            //print_r($data); die();
            $validation = $validate->check($_POST, array(
                'email' => array(
                    'required' => true,
                    'min' => 6,
                    'exists' => 'users'
                ),
                'password' => array(
                    'required' =>true,
                    'min' => 4
                )
            ));

            // Validate
            if($validation->passed()){
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                
                if($loggedInUser){
                    // Create session on success login
                    //print_r($this->userModel->data()); die('....loggedInUser');
                    $this->createUserSession($this->userModel->data());
                }else{
                    $data['password_err'] = 'incorrect password';
                    //print_r($data['password_err']); die('...test1');
                    $this->view('Users/Login', $data);
                }

            }else{
                
                foreach($validation->errors() as $error => $error_values){
                    foreach($error_values as $value => $val){
                        $data[$value] = $error_values[$value];
                         //$data[array_keys($error_values)[0]] = array_values($error_values)[0]; 
                    }    
                }
                //print_r($data['email_err']); die(' ....test2');
                $this->view('Users/Login', $data);
            }
        }else{
            // Init Data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'pass_err' => ''
            ];

            // Load view 
            $this->view('users/login', $data);
        }
    }

    public function logout(){
        Session::delete(SESSION_USER_ID);
        Session::delete(SESSION_USER_EMAIL);
        Session::delete(SESSION_USER_NAME);
        redirect('users/login');
    }

    public function createUserSession($user){
        Session::put(SESSION_USER_ID, $user->id);
        Session::put(SESSION_USER_EMAIL, $user->email);
        Session::put(SESSION_USER_NAME, $user->name);
        redirect('posts/index');
    }


}

?>