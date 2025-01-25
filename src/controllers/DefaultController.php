<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        echo ($_SESSION["email"]);
        $this->render('home');
    }
    public function home() {
        echo ($_SESSION["email"]);
        $this->render('home');
    }
}