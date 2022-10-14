<?php

namespace Controllers;

use Models\Question;
use Models\Test;
use Models\User;

class HomeController extends BaseController
{
    /**
     * Contains all tests from database
     * @var array|false
     */
    public $tests;

    /**
     * Contains $_POST['username'] if provided
     * @var null
     */
    public $username;

    /**
     * Contains $_POST['test_id'] selected by user
     * @var null
     */
    public $testId;

    public function __construct()
    {
        parent::__construct();
        $this->tests = (new Test($this->connection))->getAll();
        $this->username = null;
        $this->testId = null;
    }

    /**
     * Handle view permissions, determine POST or GET request
     * @return array|array[]|false[]|void
     */
    public function handle()
    {
        // if no tests are found in the database return error
        if (!$this->tests) {
            $this->setErrorMessage('Datubāzē nav neviena testa!');
            return [
                'error' => $this->getErrorMessage(),
            ];
        }

        // if test has been started, redirect to the test
        if ($this->testService->testIsStarted()) {
            header('Location: /index.php?page=' . PAGE_TEST);
            exit;
        }

        // handle POST request
        if ($_POST) {
            $this->setUsername();
            $this->setTestId();
            return $this->post();
        }

        // handle GET request
        return $this->get();
    }

    /**
     * Handle GET request
     * @return array[]|false[]
     */
    public function get()
    {
        return ['tests' => $this->tests];
    }

    /**
     * Handle POST request
     * @return array|void
     * @throws \Exception
     */
    public function post()
    {
        // validate user input
        if (!$this->validate()) {
            return [
                'error' => $this->getErrorMessage(),
                'tests' => $this->tests,
                'name' => $this->username,
                'test' => $this->testId
            ];
        }

        // get first question ID if any
        $firstQuestion = (new Question($this->connection))->getFirstId($this->testId);

        if (!$firstQuestion) {
            $this->setErrorMessage('Izvēlētajam testam nav neviena jautājuma!');
            return [
                'error' => $this->getErrorMessage(),
                'tests' => $this->tests,
                'name' => $this->username,
            ];
        }

        // create user
        $userId = (new User($this->connection))->create($this->testId, $this->username);

        // store values in session
        $this->testService->setUserId($userId);
        $this->testService->setUsername($this->username);
        $this->testService->setTestId($this->testId);
        $this->testService->setCurrentQuestionId($firstQuestion);
        $this->testService->setCurrentQuestionInTurn(0);
        $this->testService->setNumberOfQuestionsInTest((new Question($this->connection))->getNumberOfQuestionsForTest($this->testId));

        header('Location: /index.php?page=' . PAGE_TEST);
        exit;
    }

    /**
     * Format user input name
     * @return void
     */
    private function setUsername()
    {
        $this->username = isset($_POST['name']) ? trim($_POST['name']) : null;
    }

    /**
     * Format user input test_id
     * @return void
     */
    private function setTestId()
    {
        $this->testId = isset($_POST['test_id']) ? (int)$_POST['test_id'] : null;
    }

    /**
     * Validate user input
     * @return bool
     */
    private function validate()
    {
        if (is_null($this->username)) {
            $this->setErrorMessage('Netika norādīts vārds!');
            return false;
        }
        if (strlen($this->username) < 3 || strlen($this->username) > 250) {
            $this->setErrorMessage('Vārdam jāsastāv no 3 līdz 250 rakstu zīmēm!');
            return false;
        }
        if (is_null($this->testId)) {
            $this->setErrorMessage('Netika norādīts testa variants!');
            return false;
        }

        if (!in_array($this->testId, array_column($this->tests, 'id'))) {
            $this->setErrorMessage('Ievadītā testa vērtība nav derīga!');
            return false;
        }
        return true;
    }
}