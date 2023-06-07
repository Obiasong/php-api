<?php


class EventsGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnnection();
    }

    public function getAllEvents(): array
    {
        $sql = "SELECT id, name, city, country, start_date as startDate, end_date as endDate FROM events";
        $statement = $this->conn->query($sql);

        return $statement->fetchAll(PDO::FETCH_CLASS, Event::class);
    }

    public function getTermEvents(string $term): array
    {
        $sql = "SELECT id, name, city, country, start_date as startDate, end_date as endDate FROM events WHERE city LIKE 
                                                                                               :term OR country LIKE :term";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(":term", '%' . $term . '%');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Event::class);
    }

    public function getDateEvents(string $searchDate): array
    {
        $sql = "SELECT id, name, city, country, start_date as startDate, end_date as endDate FROM events WHERE
                                                                                               :searchDate BETWEEN start_date AND end_date";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(":searchDate", $searchDate);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Event::class);
    }

    public function getTermAndDateEvents(string $searchTerm, string $searchDate): array
    {
        $sql = "SELECT id, name, city, country, start_date as startDate, end_date as endDate FROM events WHERE (city LIKE :term OR country LIKE :term) AND
                                                                     :searchDate BETWEEN start_date AND end_date";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(":searchDate", $searchDate);
        $statement->bindValue(":term", '%' . $searchTerm . '%');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Event::class);
    }
}