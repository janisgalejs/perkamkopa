<?php

namespace Models;

class User extends BaseModel
{
    /**
     * Table name in the database
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Create new user in the database
     * @param int $testId
     * @param string $username
     * @return false|mixed|string
     * @throws \Exception
     */
    public function create(int $testId, string $username)
    {
        return $this->connection->insert("INSERT INTO {$this->table} (test_id, username) VALUES (:test_id, :username)",
            [
                'test_id' => $testId,
                'username' => $username
            ]
        );
    }

    /**
     * Set test completed by the user
     * @param int $userId
     * @return mixed|void
     * @throws \Exception
     */
    public function setComplete(int $userId)
    {
        return $this->connection->update("UPDATE {$this->table} SET complete = 1 WHERE id = :user_id", ['user_id' => $userId]);
    }

    /**
     * Check if specific test is completed by the user
     * @param int $userId
     * @param int $testId
     * @return int|mixed
     * @throws \Exception
     */
    public function testIsComplete(int $userId, int $testId)
    {
        return $this->connection->select("SELECT complete FROM {$this->table} WHERE id = :user_id AND test_id = :test_id LIMIT 1",
            [
                'user_id' => $userId,
                'test_id' => $testId
            ]
        )[0]['complete'] ?? 0;
    }
}