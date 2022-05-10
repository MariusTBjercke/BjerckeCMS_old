<?php

session_start();

use Bjercke\Entity\User;
use Bjercke\Site;
use Bjercke\SqlConnection;
use Bjercke\PageRenderer as View;
use Bjercke\TileRenderer;
use Bjercke\TwigExtensions as TwigExtension;

// Development only
//error_reporting(E_ALL & ~E_WARNING);

const developmentMode = true;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$em = SqlConnection::getInstance()->getEntityManager();

$site = Site::getInstance();

$pageName = $site->getPageName();

if ($site->getCurrentUser()->getLoggedIn()) {
    // Get fresh user data from DB;
    $user = $em->find(User::class, $site->getCurrentUser());

    // If on logout page or if the user is logged out in DB but still has a session
    if ($pageName === 'logout' || !$user->getLoggedIn()) {
        $site->logout();
    }
}

/**
 * Twig settings
 */
$pageRenderer = View::getInstance();
$tileRenderer = TileRenderer::getInstance();

// Site helper object
$pageRenderer->addGlobal('site', Site::getInstance());
$tileRenderer->addGlobal('site', Site::getInstance());

// Custom template paths
$pageRenderer->addPath(__DIR__ . '/../assets/templates/layouts/components', 'components');
$pageRenderer->addPath(__DIR__ . '/../assets/templates/layouts/grid', 'grid');
$pageRenderer->addPath(__DIR__ . '/../includes/classes/Tiles', 'tiles');

// Twig custom functions
$pageRenderer->addGlobalFunction('redirect', [TwigExtension\TwigRedirect::class, 'redirect']);
$pageRenderer->addGlobalFunction('redirectIfLoggedIn', [TwigExtension\TwigRedirect::class, 'redirectIfLoggedIn']);

$user = $site->getCurrentUser();

// Clear action session data
unset($_SESSION['action']);