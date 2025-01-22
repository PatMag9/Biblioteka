<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Genre.php';
class GenreRepository extends Repository
{
    public function getGenres(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            select * from public.genres;
        ');
        $stmt->execute();
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($genres as $genre){
            $result[] = new Genre(
                $genre['id_genre'],
                $genre['genre_name']
            );
        }
        return $result;
    }
}