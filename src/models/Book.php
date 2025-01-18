<?php

class Book
{
    private $title;
    private $authors;
    private $genre;
    private $publisher;
    private $cover;

    public function __construct($title, $authors, $genre, $publisher, $cover)
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

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getAuthors(): string //:array(?)
    {
        return $this->authors;
    }

    public function setAuthors($authors): void
    {
        $this->authors = $authors;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre($genre): void
    {
        $this->genre = $genre;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher($publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getCover(): string
    {
        return $this->cover;
    }

    public function setCover($cover): void
    {
        $this->cover = $cover;
    }

}