<?php

class Genre
{
    private $ID;
    private $genreName;

    public function __construct($ID, $genreName)
    {
        $this->ID = $ID;
        $this->genreName = $genreName;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getGenreName()
    {
        return $this->genreName;
    }
}