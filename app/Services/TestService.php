<?php

namespace Services;

use Classes\DatabaseConnection;
use Classes\SessionManager;
use Models\Question;
use Models\QuestionAnswer;
use Models\User;

class TestService
{
    /**
     * @var SessionManager
     */
    protected $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * Check if test is in progress
     * @return bool
     */
    public function testIsStarted()
    {
        if (!$this->session->has(SESSION_KEY_USERNAME)
            || !$this->session->has(SESSION_KEY_TEST_ID)
            || !$this->session->has(SESSION_KEY_CURRENT_QUESTION_ID)) {
            return false;
        }
        return true;
    }

    /**
     * Store user id in the session
     * @param string $value
     * @return void
     */
    public function setUserId(int $value)
    {
        $this->session->set(SESSION_KEY_USER_ID, $value);
    }

    /**
     * Get user id from the session
     * @return mixed|null
     */
    public function getUserId()
    {
        return $this->session->get(SESSION_KEY_USER_ID);
    }

    /**
     * Store username in the session
     * @param string $value
     * @return void
     */
    public function setUsername(string $value)
    {
        $this->session->set(SESSION_KEY_USERNAME, $value);
    }

    /**
     * Get username from the session
     * @return mixed|null
     */
    public function getUsername()
    {
        return $this->session->get(SESSION_KEY_USERNAME);
    }

    /**
     * Store selected test ID in the session
     * @param int $value
     * @return void
     */
    public function setTestId(int $value)
    {
        $this->session->set(SESSION_KEY_TEST_ID, $value);
    }

    /**
     * Get selected test ID from the session
     * @return mixed|null
     */
    public function getTestId()
    {
        return $this->session->get(SESSION_KEY_TEST_ID);
    }

    /**
     * Store current question ID in the session
     * @param int $value
     * @return void
     */
    public function setCurrentQuestionId(int $value)
    {
        $this->session->set(SESSION_KEY_CURRENT_QUESTION_ID, $value);
    }

    /**
     * Get current question ID from the session
     * @return mixed|null
     */
    public function getCurrentQuestionId()
    {
        return $this->session->get(SESSION_KEY_CURRENT_QUESTION_ID);
    }

    /**
     * Store current question in turn in the session
     * @param int $value
     * @return void
     */
    public function setCurrentQuestionInTurn(int $value)
    {
        $this->session->set(SESSION_KEY_CURRENT_QUESTION_IN_TURN, $value);
    }

    /**
     * Get current question in turn from the session
     * @return mixed|null
     */
    public function getCurrentQuestionInTurn()
    {
        return $this->session->get(SESSION_KEY_CURRENT_QUESTION_IN_TURN);
    }

    /**
     * Increment current question in turn in the session
     * @return void
     */
    public function incrementCurrentQuestionInTurn()
    {
        $this->setCurrentQuestionInTurn($this->getCurrentQuestionInTurn() + 1);
    }

    /**
     * Store number of questions in current test in the session
     * @param int $value
     * @return void
     */
    public function setNumberOfQuestionsInTest(int $value)
    {
        $this->session->set(SESSION_KEY_NUMBER_OF_QUESTIONS_IN_TEST, $value);
    }

    /**
     * Get number of questions in current test
     * @return mixed|null
     */
    public function getNumberOfQuestionsInTest()
    {
        return $this->session->get(SESSION_KEY_NUMBER_OF_QUESTIONS_IN_TEST);
    }

    /**
     * Calculate test progress in %
     * @param int $numberOfQuestions
     * @param int $questionInTurn
     * @return float
     */
    public function calculateCurrentProgress()
    {
        return ceil($this->getCurrentQuestionInTurn() / $this->getNumberOfQuestionsInTest() * 100);
    }

    /**
     * Get current question
     * @param DatabaseConnection $connection
     * @return mixed|null
     */
    public function getCurrentQuestion(DatabaseConnection $connection)
    {
        return (new Question($connection))->getById($this->getCurrentQuestionId()) ?? null;
    }

    /**
     * Get all answers for current question
     * @param DatabaseConnection $connection
     * @return array|mixed
     * @throws \Exception
     */
    public function getCurrentQuestionAnswers(DatabaseConnection $connection)
    {
        return (new QuestionAnswer($connection))->getAllByQuestionId($this->getCurrentQuestionId()) ?? [];
    }

    /**
     * Determine if test is completed and completed page should be shown ar this time
     * @param DatabaseConnection $connection
     * @return bool
     * @throws \Exception
     */
    public function testIsComplete(DatabaseConnection $connection)
    {
        return $this->testIsStarted() && (new User($connection))->testIsComplete($this->getUserId(), $this->getTestId());
    }
}