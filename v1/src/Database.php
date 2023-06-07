<?php


class Database
{
    public function __construct(private string $host = "localhost", private string $database = "php-api",
                                private string $username = "root", private string $password = "")
    {

    }

    public function getConnnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";

        return new PDO($dsn, $this->username, $this->password);
    }
}