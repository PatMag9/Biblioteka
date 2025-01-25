<?php

require 'Routing.php';

$path=trim($_SERVER['REQUEST_URI'], '/');
$path=parse_url($path, PHP_URL_PATH);

Routing::get('','DefaultController');
Routing::get('home','DefaultController');
Routing::get('register','SecurityController');
Routing::get('main','BookController');
Routing::get('book','BookController');
Routing::post('login','SecurityController');
Routing::post('addBook','BookController');
Routing::post('search','BookController');
Routing::post('orderByCondition','BookController');
Routing::run($path);