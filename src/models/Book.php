<?php

class Book
{
    private $title;
    private $authors = array();
    private $genre;
    private $publisher;
    private $cover;

    public function __construct($title, array $authors, $genre, $publisher, $cover)
    {
        $this->title = $title;
        $this->authors = $authors;
        $this->genre = $genre;
        $this->publisher = $publisher;
        $this->cover = $cover;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function getCover(): string
    {
        return $this->cover;
    }

}