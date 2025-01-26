<?php

class Book
{
    private $ID;
    private $title;
    private $authors = array();
    private $genre;
    private $publisher;
    private $cover;
    private $isReserved;
    private $isReservedBy=0;

    public function __construct($ID, $title, array $authors, $genre, $publisher, $cover, $isReserved, $isReservedBy)
    {
        $this->ID = $ID;
        $this->title = $title;
        $this->authors = $authors;
        $this->genre = $genre;
        $this->publisher = $publisher;
        $this->cover = $cover;
        $this->isReserved = $isReserved;
        $this->isReservedBy = $isReservedBy;
    }

    public function getID()
    {
        return $this->ID;
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

    public function IsReserved()
    {
        return $this->isReserved;
    }

    public function setIsReserved($isReserved): void
    {
        $this->isReserved = $isReserved;
    }

    public function IsReservedBy()
    {
        return $this->isReservedBy;
    }

    public function setIsReservedBy($isReservedBy): void
    {
        $this->isReservedBy = $isReservedBy;
    }
}