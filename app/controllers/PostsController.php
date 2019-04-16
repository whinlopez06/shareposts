<?php 

class PostsController extends Controller {

    
    public function __construct(){
        if(!Session::isLoggedIn()){
            redirect('users/login');
        }
        // base controller will require the class and return Instantiate of that class
        $this->postModel = $this->model('Post');

        // just init the user model instead of making complicated query
        $this->userModel = $this->model('User');

    }

    public function index(){
        // Get posts
        $posts = $this->postModel->getPostsWithUser();

        $data = [
            'posts' => $posts
        ];
        
        $this->view('posts/index', $data);
    }

    public function add(){

        // for submit via post
        if($_SERVER['REQUEST_METHOD']  == 'POST'){
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = $_POST;
            $data = array_merge($data, array('user_id' => Session::get(SESSION_USER_ID)), array('title_err' => ''), array('body_err' => ''));
            //print_r($data);die('...test');
            // init validate class for validation
            $validate = new Validate();
            $validation = $validate->check($data, array(
                'title' => array(
                    'required' => true,
                    'min' => 3
                ),
                'body' => array(
                    'required' => true,
                    'min' => 3
                )
            ));

            if($validation->passed()){
                // save the post using model method
                if($this->postModel->addPost($data)){
                    Session::flash('post_message', 'Post Added Successfully');
                    //Session::flash('post_class', 'alert alert-success');
                    redirect('posts/');
                }
                
            }else{
                // validation fail. Load with errors
                foreach($validation->errors() as $error => $error_values){
                    foreach($error_values as $value => $val){
                        $data[$value] = $error_values[$value];
                         //$data[array_keys($error_values)[0]] = array_values($error_values)[0]; 
                    }    
                }
                $this->view('posts/add', $data);
            }

        } // for request via get
         else{
            $data = [
                'title' => '',
                'body' => ''
            ];
    
            $this->view('posts/add', $data);
        }

    }


    public function show($id){

        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];
        //$data['id'] = $id;
       
        $this->view('posts/show', $data);
    }


    public function edit($id){

        // Check if this post belongs to the login user
        $post = $this->postModel->getPostById($id);
        if($post->user_id != Session::get(SESSION_USER_ID)){
            redirect('posts');
        }

        // for submit via post
        if($_SERVER['REQUEST_METHOD']  == 'POST'){
        
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = $_POST;
            $data = array_merge($data, array('id' => $id), array('user_id' => Session::get(SESSION_USER_ID)), array('title_err' => ''), array('body_err' => ''));
            //print_r($data); die(' .... edit post');
            // init validate class for validation
            $validate = new Validate();
            $validation = $validate->check($data, array(
                'title' => array(
                    'required' => true,
                    'min' => 3
                ),
                'body' => array(
                    'required' => true,
                    'min' => 3
                )
            ));

            if($validation->passed()){
                // save the post using model method
                if($this->postModel->updatePost($data)){
                    Session::flash('post_message', 'Post Updated Successfully');
                    //Session::flash('post_class', 'alert alert-success');
                    redirect('posts/');
                }
                
            }else{
                // validation fail. Load with errors
                foreach($validation->errors() as $error => $error_values){
                    foreach($error_values as $value => $val){
                        $data[$value] = $error_values[$value];
                         //$data[array_keys($error_values)[0]] = array_values($error_values)[0]; 
                    }    
                }
                $this->view('posts/edit', $data);
            }

        } // for request via get
         else{
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            
            $this->view('posts/edit', $data);
        }

    }

    public function delete($id){
        $post = $this->postModel->getPostById($id);
        if($post->user_id != Session::get(SESSION_USER_ID)){
            redirect('posts');
        }
        
        if($_SERVER['REQUEST_METHOD']  == 'POST'){
            // request must be post to proceed
            if($this->postModel->deletePost($id)){
                Session::flash('post_message', 'Post Removed Successfully');
                redirect('posts');
            }else{
                die('Something went wrong.');
            }
        }else{
            redirect('posts');
        }
    }


}

?>