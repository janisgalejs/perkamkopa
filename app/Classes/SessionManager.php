<?php

namespace Classes;

use Interfaces\SessionManagerInterface;

class SessionManager implements SessionManagerInterface
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public function set(string $key, $value): SessionManagerInterface
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }
}