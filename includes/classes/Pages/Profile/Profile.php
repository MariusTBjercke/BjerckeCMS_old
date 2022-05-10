<?php

use Bjercke\Entity\User;
use Bjercke\Exception\NotLoggedInException;
use Bjercke\SqlConnection;
use Bjercke\Tile;

class Profile extends Tile {

    public User $user;

    protected function __construct() {
        parent::__construct();
        $this->user = $this->getProfileUser();
    }

    /**
     * Return user object from URL or Site current user.
     *
     * @return User
     */
    public function getProfileUser(): User {
        $name = $_REQUEST['name'] ?? [""];
        $em = $this->db->getEntityManager();
        $user = $em->getRepository(User::class)->findOneBy(['username' => $name]);

        if ($user instanceof User) {
            return $user;
        }

        try {
            return $this->getCurrentUser();
        } catch (NotLoggedInException $e) {
            echo $e->getMessage();

            return new User();
        }
    }

}