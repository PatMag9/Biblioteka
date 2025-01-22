<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Book.php';
require_once 'AuthorRepository.php';
class BookRepository extends Repository
{
    private $authorRepository;

    public function __construct()
    {
        parent::__construct();
        $this->authorRepository = new AuthorRepository;
    }

    public function getBook(int $id): ?Book
    {
        $stmt = $this->database->connect()->prepare('
            select b.title, (a.name||a.surname) author, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            JOIN public.book_author ba USING (id_book)
            JOIN public.authors a USING (id_author)
            WHERE id_book = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if($book == false){
            return null;
        }

        return new Book(
            $book['title'],
            $book['author'],
            $book['genre'],
            $book['publisher'],
            $book['cover']
        );
    }
    public function getBooks(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
        ');
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($books as $book){
            $resultAuthors = $this->authorRepository->getAuthorsByBookId($book['id_book']);
            $result[] = new Book(
                $book['title'],
                $resultAuthors,
                $book['genre'],
                $book['publisher'],
                $book['cover']
            );
        }
        return $result;
    }
    public function addBook(Book $book): void
    {
        //$date = new DateTime();
        $stmt=$stmt = $this->database->connect()->prepare('
            select max(id_book) from public.books
        ');
        $stmt->execute();

        $idBook = $stmt->fetch(PDO::FETCH_ASSOC);
        $idBook['max']++;

        $stmt = $this->database->connect()->prepare('
            insert into public.books(id_book, title, id_genre, id_publisher, cover)
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $idBook['max'],
            $book->getTitle(),
            $book->getGenre(),
            $book->getPublisher(),
            $book->getCover()
        ]);

        foreach ($book->getAuthors() as $author){
            $stmt = $this->database->connect()->prepare('
            insert into public.book_author(id_book, id_author) 
            values(?, ?)
            ');
            $stmt->execute([
                $idBook['max'],
                $author
            ]);
        }

    }
}