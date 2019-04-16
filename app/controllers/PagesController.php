<?php

class PagesController extends Controller {

    public function __construct(){

    }

    public function index(){
        if(!Session::isLoggedIn()){
            redirect('posts');
        }

        $data = [
            'title' => 'SharePosts',
            'description' => 'Simple microblog built on custom MVC framework'
        ];

        //$this->view('pages/index', ['title' => 'Welcome']);
        $this->view('pages/index', $data);
    }

    public function about(){
        //echo "<br> about method!<br/>";
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with other users'
        ];

        $this->view('pages/about', $data);
    }

}

?>