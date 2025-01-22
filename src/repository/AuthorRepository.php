<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Author.php';
class AuthorRepository extends Repository
{
    public function getAuthors(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            select * from public.authors;
        ');
        $stmt->execute();
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($authors as $author){
            $result[] = new Author(
                $author['id_author'],
                $author['name'],
                $author['surname']
            );
        }
        return $result;
    }
    public function getAuthorsByBookId(int $id): array{
        $result = [];

        $stmt = $this->database->connect()->prepare('
            select a.id_author, a.name, a.surname FROM public.books b
            JOIN public.book_author ba USING (id_book)
            JOIN public.authors a USING (id_author)
            WHERE b.id_book = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($authors as $author){
            $result[] = new Author(
                $author['id_author'],
                $author['name'],
                $author['surname']
            );
        }

        return $result;
    }

}