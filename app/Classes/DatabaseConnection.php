<?php

namespace Classes;

use Interfaces\DatabaseConnectionInterface;
use PDO;
use Exception;

class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var PDO|null
     */
    private $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8mb4',
                DATABASE_USER,
                DATABASE_PASSWORD
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function insert($statement = '', $parameters = [])
    {
        try {
            $this->executeStatement($statement, $parameters);
            return $this->connection->lastInsertId();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($statement = '', $parameters = [])
    {
        try {
            $this->executeStatement($statement, $parameters);
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function select($statement = '', $parameters = [])
    {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetchAll();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function close(): void
    {
        $this->connection = null;
    }

    private function executeStatement($statement = '', $parameters = [])
    {
        try {
            $stmt = $this->connection->prepare($statement);
            $stmt->execute($parameters);
            return $stmt;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}