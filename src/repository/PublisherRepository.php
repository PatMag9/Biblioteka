<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Publisher.php';
class PublisherRepository extends Repository
{
    public function getPublishers(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            select * from public.publishers;
        ');
        $stmt->execute();
        $publishers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($publishers as $publisher){
            $result[] = new Publisher(
                $publisher['id_publisher'],
                $publisher['publisher_name']
            );
        }
        return $result;
    }
}