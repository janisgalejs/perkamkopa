<?php

namespace Models;

class Question extends BaseModel
{
    /**
     * Table name in the database
     * @var string
     */
    protected $table = 'questions';

    /**
     * Get ID of the first question for a specific test
     * @param int $testId
     * @return mixed|null
     * @throws \Exception
     */
    public function getFirstId(int $testId)
    {
        return $this->connection->select("SELECT id FROM {$this->table} WHERE test_id = :test_id ORDER BY id ASC LIMIT 1", ['test_id' => $testId])[0]['id'] ?? null;
    }

    /**
     * Get ID of the next question for a specific test
     * @param int $testId
     * @param int $questionId
     * @return mixed|null
     * @throws \Exception
     */
    public function getNextId(int $testId, int $questionId)
    {
        return $this->connection->select("SELECT id FROM {$this->table} WHERE test_id = :test_id AND id > :question_id ORDER BY id ASC LIMIT 1",
                [
                    'test_id' => $testId,
                    'question_id' => $questionId
                ]
            )[0]['id'] ?? null;
    }

    /**
     * Get question data by ID
     * @param int $id
     * @return mixed|null
     * @throws \Exception
     */
    public function getById(int $id)
    {
        return $this->connection->select("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1", ['id' => $id])[0] ?? null;
    }

    /**
     * Get number of questions for a specific test
     * @param int $testId
     * @return int|mixed
     * @throws \Exception
     */
    public function getNumberOfQuestionsForTest(int $testId)
    {
        return $this->connection->select("SELECT COUNT(id) AS count FROM {$this->table} WHERE test_id = :test_id", ['test_id' => $testId])[0]['count'] ?? 0;
    }
}