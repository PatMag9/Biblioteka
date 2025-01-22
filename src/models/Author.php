<?php

class Author
{
    private $ID;
    private $name;
    private $surname;

    public function __construct($ID, $name, $surname)
    {
        $this->ID = $ID;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

}