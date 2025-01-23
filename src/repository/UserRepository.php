<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user == false){
            return null;
        }

        return new User(
            $user['email'],
            $user['password']
        );
    }
    public function addUser(User $user){
        $stmt=$stmt = $this->database->connect()->prepare('
            select max(id_user) from public.users
        ');
        $stmt->execute();

        $idUser = $stmt->fetch(PDO::FETCH_ASSOC);
        $idUser['max']++;


        $stmt = $this->database->connect()->prepare('
            insert into public.users(id_user, email, password)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([
            $idUser['max'],
            $user->getEmail(),
            $user->getPassword()
        ]);

        $stmt = $this->database->connect()->prepare('
            insert into public.user_role(id_user, id_role)
            VALUES (?, ?)
        ');
        $stmt->execute([
            $idUser['max'],
            1
        ]);

    }
}