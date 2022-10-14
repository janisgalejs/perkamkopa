<?php

namespace Interfaces;

interface SessionManagerInterface
{
    /**
    * @param string $key
    * @return mixed
    */
    public function get(string $key);

    /**
    * @param string $key
    * @param mixed $value
    * @return SessionManagerInterface
    */
    public function set(string $key, $value): self;

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void;

    /**
     * @return void
     */
    public function destroy(): void;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;
}