<?php

namespace Controllers;

use Classes\DatabaseConnection;
use Classes\SessionManager;
use Services\TestService;

class BaseController
{
    /**
     * Established database connection
     * @var DatabaseConnection
     */
    protected $connection;

    /**
     * Contains values saved to the session
     * @var SessionManager
     */
    protected $session;

    /**
     * Manage additional test services
     * @var TestService
     */
    protected $testService;

    /**
     * Contains error message
     * @var null
     */
    protected $errorMessage;

    /**
     * Build necessary instances
     */
    public function __construct()
    {
        $this->connection = new DatabaseConnection();
        $this->session = new SessionManager();
        $this->testService = new TestService($this->session);
        $this->errorMessage = null;
    }

    /**
     * destroy necessary instandes
     */
    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * Set error message
     * @param string $value
     * @return void
     */
    public function setErrorMessage(string $value): void
    {
        $this->errorMessage = $value;
    }

    /**
     * Get error message
     * @return null
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}