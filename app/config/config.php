<?php

session_start();    // start the session in php

// DB Params in global
define('DB_HOST', 'localhost');
define('DB_NAME', 'shareposts');
define('DB_USER', 'root');
define('DB_PASS', '');

// Session names
define('SESSION_USER_ID', 'user_id');
define('SESSION_USER_EMAIL', 'user_email');
define('SESSION_USER_NAME', 'user_name');

// App ROOT
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$domain = $_SERVER['SERVER_NAME'];
$url = $protocol . '://' . $domain;
$doc_root = ltrim($_SERVER['SCRIPT_NAME'], '/');

$doc_root = explode("/", $doc_root);
$doc_root = $url . '/' . $doc_root[0];

//--define('URLROOT', 'http://localhost/shareposts/');
define('URLROOT', $doc_root);

// SITE NAME
define('SITENAME', 'SharePosts');

?>