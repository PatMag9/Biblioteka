<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/BookController.php';

class Routing {
    public static $routes;

    public static function get($url, $controller) {
        self::$routes[$url]=$controller;
    }
    public static function post($url, $controller) {
        self::$routes[$url]=$controller;
    }

    public static function run($url) {
        $urlParts = explode("/",$url);
        $action = $urlParts[0];
        $id = $urlParts[1] ?? '';

        if(!array_key_exists($action,self::$routes)) {
            die("wrong url!");
        }

        $controller=self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $object->$action($id);
    }
}