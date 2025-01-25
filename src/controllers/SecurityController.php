<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login(){

        if (!$this->isPost()){
            return $this->render('login');
        }

        $email=$_POST['email'];
        $password=$_POST['password'];

        $user = $this->userRepository->getUser($email);

        if (!$user){
            return $this->render('login', ['messages'=>['Dany użytkownik nie istnieje']]);
        }
        if (!password_verify($password, $user->getPassword())){
            return $this->render('login', ['messages'=>['Błędne hasło']]);
        }

        //return $this->render('main');
        header("Location: http://localhost:8080/main/");
        die();
    }
    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];

        if ($password !== $confirmedPassword) {
            return $this->render('register', ['messages' => ['Podane hasła się nie zgadzają']]);
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $user = new User($email, $hash);

        $this->userRepository->addUser($user);

        //return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
        header("Location: http://localhost:8080/main/");
        die();
    }
}