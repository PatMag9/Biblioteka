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
            $user['id_user'],
            $user['email'],
            $user['password'],
            $this->isUserAdmin($user['email'])
        );
    }
    public function addUser(User $user){
        $db = $this->database->connect();
        try {

            // Rozpoczęcie transakcji
            $db->beginTransaction();

            // Przygotowanie i wykonanie zapytania z CTE
            $stmt = $db->prepare('
            WITH identity AS (
                INSERT INTO public.users (email, password)
                VALUES (?, ?)
                RETURNING id_user
            )
            INSERT INTO public.user_role (id_user, id_role)
            SELECT id_user, 1 FROM identity
            ');

            $stmt->execute([
                $user->getEmail(),
                $user->getPassword()
            ]);

            // Zatwierdzenie transakcji
            $db->commit();
        } catch (Exception $e) {
            // W przypadku błędu wycofanie transakcji
            $db->rollBack();
            die("Nie udało się dodać użytkownika: " . $e->getMessage());
        }
    }
    private function isUserAdmin(String $email): bool{
        $stmt = $this->database->connect()->prepare('
            SELECT ur.id_role FROM public.users u
            join public.user_role ur using (id_user)
            WHERE email = :email
        ');
        $stmt->bindParam(':email',$email , PDO::PARAM_STR);
        $stmt->execute();

        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($roles as $role){
            if($role["id_role"] === 2){
                return true;
            }
        }
        return false;
    }
}