<?php

namespace Models;

class UserAnswer extends BaseModel
{
    /**
     * Table name in the database
     * @var string
     */
    protected $table = 'user_answers';

    /**
     * Save user answer in the database
     * @param int $userId
     * @param int $questionId
     * @param int $answerId
     * @return false|mixed|string
     * @throws \Exception
     */
    public function create(int $userId, int $questionId, int $answerId)
    {
        return $this->connection->insert("INSERT INTO {$this->table} (user_id, question_id, question_answer_id) VALUES (:user_id, :question_id, :question_answer_id)",
            [
                'user_id' => $userId,
                'question_id' => $questionId,
                'question_answer_id' => $answerId
            ]
        );
    }

    /**
     * Get number of correct answers for specific user
     * @param int $userId
     * @param int $testId
     * @return int|mixed
     * @throws \Exception
     */
    public function getCorrectAnswers(int $userId, int $testId)
    {
        $sql = "SELECT COUNT(*) as count
                FROM {$this->table}
                LEFT JOIN question_answers ON user_answers.question_id = question_answers.question_id 
                LEFT JOIN questions ON questions.id = question_answers.question_id
                WHERE questions.test_id = :test_id
                AND user_answers.user_id = :user_id
                AND question_answers.correct = 1
                AND user_answers.question_answer_id = question_answers.id";
        return $this->connection->select($sql, [
            'user_id' => $userId,
            'test_id' => $testId,
        ])[0]['count'] ?? 0;
    }
}