<?php

class Publisher
{
    private $ID;
    private $publisherName;

    public function __construct($ID, $publisherName)
    {
        $this->ID = $ID;
        $this->publisherName = $publisherName;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getPublisherName()
    {
        return $this->publisherName;
    }

}