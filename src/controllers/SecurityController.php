<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
class SecurityController extends AppController
{
    public function login(){
        $userRepository = new UserRepository();


        if (!$this->isPost()){
            return $this->render('login');
        }

        $email=$_POST['email'];
        $password=$_POST['password'];

        $user = $userRepository->getUser($email);

        if (!$user){
            return $this->render('login', ['messages'=>['Dany użytkownik nie istnieje']]);
        }
        if ($user->getEmail() !== $email){
            return $this->render('login', ['messages'=>['Błędny adres e-mail']]);
        }

        if ($user->getPassword() !== $password){
            return $this->render('login', ['messages'=>['Błędne hasło']]);
        }

        return $this->render('main');
    }
}