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
     * @return object
     * @throws NotLoggedInException
     */
    public function getCurrentUser(): object
    {
        $storage = new WebStorage('user');

        if ($storage->getSessionOrCookieSet()) {
            return $storage->getUnserializedValue();
        }

        throw new NotLoggedInException();
    }

    public function getPageTitle(): string {
        return Site::getInstance()->getCurrentPage()->getTitleString();
    }
}
