<?php
session_start();
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
        if (isset($_SESSION["id"])) {
            header("Location: http://localhost:8080/main/");
            die();
        }
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
        $_SESSION["id"] = $user->getIdUser();
        $_SESSION["email"] = $user->getEmail();
        $_SESSION["isAdmin"] = $user->isAdmin();
//        if ($user->isAdmin()===true) $_SESSION["isAdmin"] = 'true';
//        else $_SESSION["isAdmin"] = 'false';
        //return $this->render('main');
        header("Location: http://localhost:8080/main/");
        die();
    }
    public function register()
    {
        if (isset($_SESSION["id"])) {
            header("Location: http://localhost:8080/main/");
            die();
        }
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

        $user = new User(0, $email, $hash, 0);

        $this->userRepository->addUser($user);

        //return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
        header("Location: http://localhost:8080/login");
        die();
    }
    public function logout(){
        session_unset();
        session_destroy();
        header("Location: http://localhost:8080");
        die();
    }
}