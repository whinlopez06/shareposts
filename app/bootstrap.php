<?php

// will bootstrap all application core files. it will basically include all needed files
//include_once('libraries/Core.php');
//include_once('libraries/Controller.php');
//include_once('libraries/Database.php');

// Load Config
require_once('config/config.php');

// Load Helper
require_once('helpers/url_helper.php');

// Autoload Core Libraries
spl_autoload_register(function($class) {
	require_once('libraries/' . $class . '.php');
});


//require_once('config/config.php');




?>