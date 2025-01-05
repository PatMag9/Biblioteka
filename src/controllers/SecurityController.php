<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
class SecurityController extends AppController
{
    public function login(){
        $user = new User('a','a','a','a');

        if (!$this->isPost()){
            return $this->render('login');
        }

        $email=$_POST['email'];
        $password=$_POST['password'];

        if ($user->getEmail() !== $email){
            return $this->render('login', ['messages'=>['Błędny adres e-mail']]);
        }

        if ($user->getPassword() !== $password){
            return $this->render('login', ['messages'=>['Błędne hasło']]);
        }

        return $this->render('main');
    }
}