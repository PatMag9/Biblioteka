<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Book.php';
require_once __DIR__.'/../repository/BookRepository.php';
class BookController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private $messages = [];
    public function addBook(){
        if ($this->isPost() && is_uploaded_file($_FILES['cover']['tmp_name']) && $this->validate($_FILES['cover'])) {
            move_uploaded_file(
                $_FILES['cover']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['cover']['name']
            );

            $book = new Book($_POST['title'], $_POST['author'], $_POST['genre'], $_POST['publisher'], $_FILES['cover']['name']);


            $this->render('main', ['messages' => $this->messages, 'book' => $book]);

        }
        else{
            $this->render('main', ['messages' => $this->messages]);
        }
    }

    private function validate(array $cover): bool
    {
        if ($cover['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'Plik jest zbyt duży';
            return false;
        }
        if(isset($cover['type']) && !in_array($cover['type'], self::SUPPORTED_TYPES)){
            $this->messages[] = 'Rozszerzenie pliku jest niepoprawnego typu';
            return false;
        }
        return true;
    }
}