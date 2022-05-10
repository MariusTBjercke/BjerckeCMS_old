<?php

namespace Bjercke;

use Bjercke\Entity\User;
use Bjercke\Exception\NotLoggedInException;
use Singleton;

/**
 * Parent class for Twig template tiles.
 */
class Tile extends Singleton {
    protected SqlConnection $db;

    protected function __construct() {
        parent::__construct();
        Singleton::__construct();
        $this->db = SqlConnection::getInstance();
    }

    /**
     * @return User
     * @throws NotLoggedInException
     */
    public function getCurrentUser(): User {
        /** @var $user User */
        if (isset($_SESSION['user'])) {
            return unserialize($_SESSION['user'], ["allowed_classes" => true]);
        }

        throw new NotLoggedInException();
    }

    public function getPageTitle(): string {
        return Site::getInstance()->getCurrentPage()->getTitle();
    }
}
