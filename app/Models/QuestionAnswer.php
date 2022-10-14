<?php

namespace Models;

class QuestionAnswer extends BaseModel
{
    /**
     * Table name in the database
     * @var string
     */
    protected $table = 'question_answers';

    /**
     * Get ID of the first question for a specific test
     * @param int $testId
     * @return mixed|null
     * @throws \Exception
     */
    public function getAllByQuestionId(int $questionId)
    {
        return $this->connection->select("SELECT * FROM {$this->table} WHERE question_id = :question_id ORDER BY id ASC", ['question_id' => $questionId]);
    }
}