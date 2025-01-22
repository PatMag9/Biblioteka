<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this->render('home');
    }
    public function home() {
        $this->render('home');
    }

    public function register() {
        $this->render('register');
    }
    
    public function book() {
        $this->render('book');
    }
}