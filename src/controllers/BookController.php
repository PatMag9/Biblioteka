<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Book.php';
require_once __DIR__.'/../repository/BookRepository.php';
require_once __DIR__.'/../repository/GenreRepository.php';
require_once __DIR__.'/../repository/PublisherRepository.php';
require_once __DIR__.'/../repository/AuthorRepository.php';
class BookController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private $messages = [];
    private $bookRepository;
    private $genreRepository;
    private $publisherRepository;
    private $authorRepository;

    public function __construct(){
        parent::__construct();
        $this->bookRepository = new BookRepository();
        $this->genreRepository = new GenreRepository();
        $this->publisherRepository = new PublisherRepository();
        $this->authorRepository = new AuthorRepository();
    }

    public function main($category) {
        if (!isset($_SESSION["id"])) {
            header("Location: http://localhost:8080");
            die();
        }
        $books = $this->bookRepository->getBooks($category);
        $genres = $this->genreRepository->getGenres();
        $publishers = $this->publisherRepository->getPublishers();
        $authors = $this->authorRepository->getAuthors();
        $pages = $this->bookRepository->getPages();
        $this->render('main', ['books' => $books, 'genres' => $genres, 'publishers' => $publishers, 'authors' => $authors, 'pages' => $pages ]);
    }

    public function book($id) {
        if (!isset($_SESSION["id"])) {
            header("Location: http://localhost:8080");
            die();
        }
        $book = $this->bookRepository->getBook($id);
        $genres = $this->genreRepository->getGenres();
        $publishers = $this->publisherRepository->getPublishers();
        $authors = $this->authorRepository->getAuthors();
        $this->render('book', ['book' => $book, 'genres' => $genres, 'publishers' => $publishers, 'authors' => $authors]);
    }

    public function addBook(){
        //var_dump($_POST);
        if ($this->isPost() && is_uploaded_file($_FILES['cover']['tmp_name']) && $this->validate($_FILES['cover'])) {
            move_uploaded_file(
                $_FILES['cover']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['cover']['name']
            );

            $book = new Book(0, $_POST['title'], $_POST['author'], $_POST['genre'], $_POST['publisher'], $_FILES['cover']['name'], false, 0);
            $this->bookRepository->addBook($book);
            header("Location: http://localhost:8080/main");
            die();
        }
        else{
            header("Location: http://localhost:8080/main");
            die();
        }
    }

    public function orderByCondition(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if($contentType == 'application/json') {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode($this->bookRepository->fetchBooksByConditions($decoded['searchString'],$decoded['orderBy'],$decoded['page'],$decoded['booksPerPage']));
        }
    }

    public function fetchPagesByCondition()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if($contentType == 'application/json') {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            echo json_encode($this->bookRepository->fetchPagesByCondition($decoded['searchString']));
        }
    }

    public function reserveBook($idBook){
        $isAlreadyReserved = $this->bookRepository->isBookReserved($idBook);
        if(!$isAlreadyReserved['isReserved']){
            $this->bookRepository->reserveBook($idBook, $_SESSION["id"]);
            header("Location: http://localhost:8080/main");
            die();
        }
        header("Location: http://localhost:8080/main");
        die();
    }

    public function cancelReserveBook($idBook){
        $this->bookRepository->cancelReserveBook($idBook, $_SESSION["id"]);
        header("Location: http://localhost:8080/main");
        die();
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