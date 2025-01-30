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
        $reservationStatus = $this->isBookReserved($book['id_book']);

        return new Book(
            $book['id_book'],
            $book['title'],
            $resultAuthors,
            $book['genre'],
            $book['publisher'],
            $book['cover'],
            $reservationStatus['isReserved'],
            $reservationStatus['idUser']
        );
    }

    public function getBooks(string $category='b.id_book'): array
    {
        switch ($category) {
            case 'new':
                $category='b.id_book';
                setcookie("orderBy", "b.id_book", time() + (86400 * 1), '/'); //time() + (86400 * 1) => obecny czas + 1 dzien
                break;
            case 'alphabetical':
                $category='b.title';
                setcookie("orderBy", "b.title", time() + (86400 * 1), '/');
                break;
            case 'publisher':
                $category='p.publisher_name';
                setcookie("orderBy", "p.publisher_name", time() + (86400 * 1), '/');
                break;
            case 'genre':
                $category='g.genre_name';
                setcookie("orderBy", "g.genre_name", time() + (86400 * 1), '/');
                break;
            default:
                $category='b.id_book';
                setcookie("orderBy", "b.id_book", time() + (86400 * 1), '/');
        }
        setcookie("searchString", "%", time() + (86400 * 1), '/');
        setcookie("page", "0", time() + (86400 * 1), '/');
        $result = [];
        $stmt = $this->database->connect()->prepare('
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            order by '.$category.', b.id_book
            LIMIT :books_per_page OFFSET 0
        ');
        $stmt->bindParam(':books_per_page', $_COOKIE['booksPerPage'], PDO::PARAM_INT);
        //$stmt->bindParam(':start', $_COOKIE['page'], PDO::PARAM_INT);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($books as $book){
            $reservationStatus = $this->isBookReserved($book['id_book']);
            $resultAuthors = $this->authorRepository->getAuthorsByBookId($book['id_book']);
            $result[] = new Book(
                $book['id_book'],
                $book['title'],
                $resultAuthors,
                $book['genre'],
                $book['publisher'],
                $book['cover'],
                $reservationStatus['isReserved'],
                $reservationStatus['idUser']
            );
        }
        return $result;
    }

    public function getPages(): int{
        $stmt = $this->database->connect()->prepare('
            select count(*) FROM public.books
        ');
        $stmt->execute();
        $total = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pages = ceil($total[0]['count']/$_COOKIE['booksPerPage']);
        setcookie("maxPage", $pages, time() + (86400 * 1), '/');
        return $pages;
    }

    public function addBook(Book $book): void
    {
        $stmt = $this->database->connect()->prepare('
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

    public function fetchBooksByConditions(string $searchString, string $orderBy, int $page, int $booksPerPage = 2)
    {
        $page=$page*$booksPerPage;
        $searchString = '%'.strtolower($searchString).'%';
        $stmt = $this->database->connect()->prepare('
            select b.id_book, b.title, g.genre_name genre, p.publisher_name publisher, b.cover FROM public.books b
            JOIN public.genres g USING (id_genre)
            JOIN public.publishers p USING (id_publisher)
            where LOWER(b.title) LIKE :searchString
            order by '.$orderBy.', b.id_book
            LIMIT :books_per_page OFFSET :start
        ');
        $stmt->bindParam(':searchString', $searchString, PDO::PARAM_STR);
        $stmt->bindParam(':books_per_page', $booksPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':start', $page, PDO::PARAM_INT);
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
            $reservationStatus = $this->isBookReserved($book['id_book']);
            $books[$N]['isReserved'] = $reservationStatus['isReserved'];
            $books[$N]['isReservedBy'] = $reservationStatus['idUser'];
            $N++;
        }
        return $books;
    }

    public function fetchPagesByCondition(string $searchString){
        $searchString = '%'.strtolower($searchString).'%';
        $stmt = $this->database->connect()->prepare('
            select count(*) FROM public.books
            where LOWER(title) LIKE :searchString
        ');
        $stmt->bindParam(':searchString', $searchString, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pages = ['pages'=>ceil($total[0]['count']/$_COOKIE['booksPerPage'])];
        return $pages;
    }


    public function isBookReserved(int $id) : array
    {
        $stmt = $this->database->connect()->prepare('
            select * from public.reservations
            where id_book = :id AND date_ended_reservation is NULL
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $reservationStatus = $stmt->fetch(PDO::FETCH_ASSOC);
        if($reservationStatus == false){
            return ['isReserved' => false, 'idUser' => 0];
        }
        return ['isReserved' => true, 'idUser' => $reservationStatus['id_user']];
    }

    public function reserveBook(int $idBook, int $idUser)
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            insert into public.reservations(id_user ,id_book, date_reserved)
            values(?,?,?)
        ');
        $stmt->execute([
            $idUser,
            $idBook,
            $date->format('Y-m-d H:i:s')
        ]);
    }

    public function cancelReserveBook(int $idBook, int $idUser)
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            UPDATE public.reservations
            SET date_ended_reservation = :date
            WHERE id_user = :idUser and id_book = :idBook and date_ended_reservation is NULL;
        ');
        $stmt->execute([
            ':date' => $date->format('Y-m-d H:i:s'),
            ':idUser' => $idUser,
            ':idBook' => $idBook
        ]);
    }
}