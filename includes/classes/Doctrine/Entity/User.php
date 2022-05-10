<?php

declare(strict_types=1);

namespace Bjercke\Entity;

use Bjercke\Enum\AccountLevel;
use Bjercke\Enum\AddonLevel;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="users")
 */
class User {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @Column(type="string", length=255)
     */
    private string $username;

    /**
     * @Column(type="string", length=255)
     */
    private string $password;

    /**
     * @Column(type="string", length=255)
     */
    private string $email;

    /**
     * @OneToMany(targetEntity="\Bjercke\Entity\Forum\Post", mappedBy="author")
     */
    private $forumPosts;

    /**
     * @OneToMany(targetEntity="\Bjercke\Entity\Article", mappedBy="author")
     */
    private $articlePosts;

    /**
     * @Column(type="boolean", name="logged_in", options={"default": false})
     */
    private bool $loggedIn;

    /**
     * @Column(type="integer", enumType="\Bjercke\Enum\AddonLevel", length=11, name="addon_level", nullable=true)
     */
    private AddonLevel $addonLevel;

    /**
     * @Column(type="integer", enumType="\Bjercke\Enum\AccountLevel", length=11, name="account_level", nullable=true)
     */
    private AccountLevel $accountLevel;

    /**
     * @Column(type="boolean", name="is_admin", options={"default": false})
     */
    private bool $isAdmin;

    /**
     * @Column(type="string", length=255, name="last_activity", nullable=true)
     */
    private string $lastActivity;

    public function __construct() {
        $this->username = '';
        $this->password = '';
        $this->loggedIn = false;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): User {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): User {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): User {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): User {
        $this->email = $email;

        return $this;
    }

    public function setLoggedIn(bool $isLoggedIn): User {
        $this->loggedIn = $isLoggedIn;

        return $this;
    }

    public function getLoggedIn(): bool {
        return $this->loggedIn;
    }

    /**
     * @return AddonLevel
     */
    public function getAddonLevel(): AddonLevel {
        return $this->addonLevel;
    }

    /**
     * @param AddonLevel $addonLevel
     * @return User
     */
    public function setAddonLevel(AddonLevel $addonLevel): User {
        $this->addonLevel = $addonLevel;

        return $this;
    }

    /**
     * @return AccountLevel
     */
    public function getAccountLevel(): AccountLevel {
        return $this->accountLevel;
    }

    /**
     * @param AccountLevel $accountLevel
     * @return User
     */
    public function setAccountLevel(AccountLevel $accountLevel): User {
        $this->accountLevel = $accountLevel;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastActivity(): string {
        return $this->lastActivity;
    }

    /**
     * @param string $lastActivity
     * @return User
     */
    public function setLastActivity(string $lastActivity): User {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin(bool $isAdmin): User {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}