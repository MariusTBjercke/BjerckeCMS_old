<?php

use Bjercke\Entity\User;
use Bjercke\DatabaseManager;

require(__DIR__ . '/../../vendor/autoload.php');

$db = DatabaseManager::getInstance();

$em = $db->getEntityManager();

$users = $em->getRepository(User::class)->findAll();

/**
 * If any users has been inactive for more than x minutes, set logged in to false.
 */
foreach ($users as $user) {
    if ($user->getLoggedIn()) {
        $lastActivity = $user->getLastActivity();

        if ($lastActivity <= strtotime('-15 minutes')) {
            $user->setLoggedIn(false);
            $em->persist($user);
            $em->flush();
        }
    }
}