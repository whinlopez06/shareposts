<?php 

/*
 * App Core Class
 * Creates URL and loads core controller
 * URL FORTMAT - /controller/method/params
 */

class Core {

    protected $currentController = 'PostsController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url =  $this->getUrl();

        // Look in controllers for first index. Capitalize the first word of the controller
        if(file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')){
            // exist then set as controller
            $this->currentController = ucwords($url[0]);
            // edl: added controller keyword
            $this->currentController  = $this->currentController . 'Controller';
            // unset index 0
            unset($url[0]);
        }
       
        // Require the controller
        //--require_once('../app/controllers/'.$this->currentController.'.php');
        require_once('../app/controllers/'. $this->currentController . '.php');

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if(isset($url[1])){
            //Check to see if method exists in the controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];

                //Unset 1 index
                unset($url[1]);
            }
        }

        //echo "<br> current method " . $this->currentMethod;
        
        // Get Params
        $this->params = $url ? array_values($url) : [];
        //print_r($this->params);

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    // get the url from the ?url= variable declared/configured on htaccess of index.php
    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');    // remove the trailing / on the url

            // format and filter the url into proper
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);  // make the url into array
            return $url; 
        }
    }


}


?>