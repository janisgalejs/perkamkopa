<?php

namespace Controllers;

use Models\Question;
use Models\User;
use Models\UserAnswer;

class TestController extends BaseController
{
    /**
     * Contains current test ID
     * @var null
     */
    protected $testId;

    /**
     * User answer from $_POST['answer']
     * @var null
     */
    protected $userAnswer;

    public function __construct()
    {
        parent::__construct();
        $this->testId = $this->testService->getTestId();
        $this->userAnswer = null;
    }

    /**
     * Handle view permissions, determine POST or GET request
     * @return array|void
     */
    public function handle()
    {
        // if test has not been started, redirect to index
        if (!$this->testService->testIsStarted()) {
            $this->session->destroy();
            header('Location: /index.php');
            exit;
        }

        // handle POST request
        if ($_POST) {
            $this->setUserAnswer();
            return $this->post();
        }

        // handle GET request
        return $this->get();
    }

    /**
     * Handle GET request
     * @return array
     * @throws \Exception
     */
    public function get()
    {
        return [
            'question' => $this->testService->getCurrentQuestion($this->connection),
            'answers' => $this->testService->getCurrentQuestionAnswers($this->connection),
            'progress' => $this->testService->calculateCurrentProgress()
        ];
    }

    /**
     * Handle POST request
     * @return array|void
     * @throws \Exception
     */
    public function post()
    {
        $answers = $this->testService->getCurrentQuestionAnswers($this->connection);
        $currentQuestionId = $this->testService->getCurrentQuestionId();

        // validate user input
        if (!$this->validate($answers)) {
            return [
                'error' => $this->getErrorMessage(),
                'question' => $this->testService->getCurrentQuestion($this->connection),
                'answers' => $answers
            ];
        }

        // save users answer
        (new UserAnswer($this->connection))->create(
            $this->testService->getUserId(),
            $currentQuestionId,
            $this->userAnswer
        );

        // next question if any or redirect to complete
        $nextQuestionId = (new Question($this->connection))->getNextId($this->testId, $currentQuestionId);
        if (!$nextQuestionId) {
            // update user with test completed
            (new User($this->connection))->setComplete($this->testService->getUserId());

            header('Location: /index.php?page=' . PAGE_COMPLETE);
            exit;
        }

        // increment next question in turn
        $this->testService->incrementCurrentQuestionInTurn();
        // set next question ID
        $this->testService->setCurrentQuestionId($nextQuestionId);

        return $this->get();
    }

    /**
     * Format answer input
     * @return void
     */
    private function setUserAnswer()
    {
        $this->userAnswer = isset($_POST['answer']) ? (int)$_POST['answer'] : null;
    }

    /**
     * Validate user input
     * @param array $answers
     * @return bool
     */
    private function validate(array $answers)
    {
        if (is_null($this->userAnswer)) {
            $this->setErrorMessage('Netika norādīta atbilde!');
            return false;
        }
        if (!in_array($this->userAnswer, array_column($answers, 'id'))) {
            $this->setErrorMessage('Ievadītā atbildes vērtība nav derīga!');
            return false;
        }
        return true;
    }
}