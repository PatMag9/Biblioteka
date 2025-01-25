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
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            WHERE id_book = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        $resultAuthors = $this->authorRepository->getAuthorsByBookId($book['id_book']);

        if($book == false){
            return null;
        }

        return new Book(
            $book['id_book'],
            $book['title'],
            $resultAuthors,
            $book['genre'],
            $book['publisher'],
            $book['cover']
        );
    }

    public function getBooks(string $category='b.id_book'): array
    {
        switch ($category) {
            case 'new':
                $category='b.id_book';
                break;
            case 'alphabetical':
                $category='b.title';
                break;
            case 'publisher':
                $category='p.publisher_name';
                break;
            case 'genre':
                $category='g.genre_name';
                break;
            default:
                $category='b.id_book';
        }
        $result = [];
        $stmt = $this->database->connect()->prepare('
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            order by '.$category.'
        ');
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($books as $book){
            $resultAuthors = $this->authorRepository->getAuthorsByBookId($book['id_book']);
            $result[] = new Book(
                $book['id_book'],
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

    public function getBooksByTitle(string $searchString)
    {
        $searchString = '%'.strtolower($searchString).'%';
        $stmt = $this->database->connect()->prepare('
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            where LOWER(b.title) LIKE :searchString
        ');
        $stmt->bindParam(':searchString', $searchString, PDO::PARAM_STR);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $N=0;
        foreach($books as $book){
            $stmt = $this->database->connect()->prepare('
                select a.id_author, a.name, a.surname FROM public.books b
                JOIN public.book_author ba USING (id_book)
                JOIN public.authors a USING (id_author)
                WHERE b.id_book = :id
            ');
            $stmt->bindParam(':id', $book['id_book'], PDO::PARAM_INT);
            $stmt->execute();

            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $books[$N]['authors'] = $authors;
            $N++;
        }
        return $books;
    }

    public function getBooksOrderedByCondition(string $condition){
        $stmt = $this->database->connect()->prepare('
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            order by '.$condition.'
        ');
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $N=0;
        foreach($books as $book){
            $stmt = $this->database->connect()->prepare('
                select a.id_author, a.name, a.surname FROM public.books b
                JOIN public.book_author ba USING (id_book)
                JOIN public.authors a USING (id_author)
                WHERE b.id_book = :id
            ');
            $stmt->bindParam(':id', $book['id_book'], PDO::PARAM_INT);
            $stmt->execute();

            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $books[$N]['authors'] = $authors;
            $N++;
        }
        return $books;
    }
}