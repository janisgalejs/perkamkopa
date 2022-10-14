<?php

namespace Models;

use Classes\DatabaseConnection;

class BaseModel
{
    /**
     * Contains database connection
     * @var DatabaseConnection
     */
    protected $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }
}