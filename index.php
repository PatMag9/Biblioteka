<?php

require 'Routing.php';

$path=trim($_SERVER['REQUEST_URI'], '/');
$path=parse_url($path, PHP_URL_PATH);

Routing::get('','DefaultController');
Routing::get('home','DefaultController');
Routing::get('register','DefaultController');
Routing::get('main','DefaultController');
Routing::get('book','DefaultController');
Routing::post('login','SecurityController');
Routing::post('addBook','BookController');
Routing::run($path);