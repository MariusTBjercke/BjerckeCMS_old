<?php

declare(strict_types=1);

namespace Bjercke;

class WebStorage
{
    private string $name;
    private string $value;
    private int $time;

    public function __construct(string $name, string $value = null, int $time = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->time = $time;
    }

    public function getSessionValue() {
        return $_SESSION[$this->name] ?? null;
    }

    public function getCookieValue() {
        return $_COOKIE[$this->name] ?? null;
    }

    public function getValue(): ?string
    {
        // Check if cookie exists
        if (isset($_COOKIE[$this->name])) {
            return $_COOKIE[$this->name];
        }

        if (isset($_SESSION[$this->name])) {
            return $_SESSION[$this->name];
        }

        return null;
    }

    public function save(): void
    {
        setcookie($this->name, $this->value, time() + $this->time);
        $_SESSION[$this->name] = $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime(int $time): void
    {
        $this->time = $time;
    }
}