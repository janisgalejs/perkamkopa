<?php

namespace Interfaces;

interface DatabaseConnectionInterface
{
    /**
     * @param string $statement
     * @param array $parameters
     * @return mixed
     */
    public function insert(string $statement, array $parameters);

    /**
     * @param string $statement
     * @param array $parameters
     * @return mixed
     */
    public function update(string $statement, array $parameters);

    /**
     * @param string $statement
     * @param array $parameters
     * @return mixed
     */
    public function select(string $statement, array $parameters);

    /**
     * @return void
     */
    public function close(): void;
}