<?php

namespace Models;

class Test extends BaseModel
{
    /**
     * Table name in the database
     * @var string
     */
    protected $table = 'tests';

    /**
     * Get all tests
     * @return array|false|mixed
     * @throws \Exception
     */
    public function getAll()
    {
        return $this->connection->select("SELECT * FROM {$this->table}");
    }
}