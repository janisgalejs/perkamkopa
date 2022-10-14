<?php

namespace Controllers;

use Models\UserAnswer;

class CompleteController extends BaseController
{
    /**
     * Handle completed page
     * @return array|void
     */
    public function handle()
    {
        // prevent to view this page if test is not completed
        if (!$this->testService->testIsComplete($this->connection)) {
            header('Location: /index.php');
            exit;
        }

        // set necessary variables
        $username = $this->testService->getUsername();
        $correctAnswers = (new UserAnswer($this->connection))->getCorrectAnswers($this->testService->getUserId(), $this->testService->getTestId());
        $numberOfQuestions = $this->testService->getNumberOfQuestionsInTest();
        // destroy all session data
        $this->session->destroy();

        return [
            'username' => $username,
            'correct_answers' => $correctAnswers,
            'number_of_questions' => $numberOfQuestions,
        ];
    }
}