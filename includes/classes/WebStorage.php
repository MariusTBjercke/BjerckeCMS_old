<?php

declare(strict_types=1);

namespace Bjercke;

class WebStorage
{
    private string $name;
    private string|null $value;
    private int|null $time;

    public function __construct(string $name, string|null $value = null, int|null $time = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->time = $time;
    }

    public function unsetSession(): void
    {
        unset($_SESSION[$this->name]);
    }

    public function getUnserializedValue(): ?object
    {
        $this->value = $this->getValue();

        if ($this->value === null) {
            return null;
        }

        return unserialize($this->value, ['allowed_classes' => true]);
    }

    public function getSessionSet() {
        return isset($_SESSION[$this->name]);
    }

    public function getCookieSet() {
        return isset($_COOKIE[$this->name]);
    }

    public function getSessionOrCookieSet(): bool
    {
        return isset($_SESSION[$this->name]) || isset($_COOKIE[$this->name]);
    }

    public function saveArray($limit = 20): void {
        // If session is not set or if bigger than 20, initialize with empty array
        if (!isset($_SESSION[$this->name]) || count($_SESSION[$this->name]) >= $limit) {
            $_SESSION[$this->name] = [];
        }

        $_SESSION[$this->name][] = $this->value;
    }

    public function getLastValueInArray() {
        if (isset($_SESSION[$this->name])) {
            return $_SESSION[$this->name][count($_SESSION[$this->name]) - 1];
        }
        return '';
    }

    public function setCookieValue($value, $time = 3600): void
    {
        $this->value = $value;
        setcookie($this->name, $value, $this->time);
    }

    public function setSessionValue($value): void
    {
        $this->value = $value;
        $_SESSION[$this->name] = $this->value;
    }

    public function getSessionValue($altValue = null) {
        return $_SESSION[$this->name] ?? $altValue;
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