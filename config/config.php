<?php

session_start();

use Bjercke\Entity\User;
use Bjercke\Site;
use Bjercke\SqlConnection;
use Bjercke\PageRenderer as View;
use Bjercke\TileRenderer;
use Bjercke\TwigExtensions as TwigExtension;
use Bjercke\WebStorage;

// Development only
//error_reporting(E_ALL & ~E_WARNING);

const developmentMode = true;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$site = Site::getInstance();

/**
 * Set website language.
 * Examples: 'en', 'no'
 */
$site->setLanguage('no');

/**
 * Allow multiple languages?
 */
$site->setMultilingual(true);

/**
 * Add body preload class.
 */
$site->addBodyClass('preload');

/**
 * Twig settings.
 */
$pageRenderer = View::getInstance();
$tileRenderer = TileRenderer::getInstance();

// Custom template paths
$pageRenderer->addPath(__DIR__ . '/../assets/templates/layouts/components', 'components');
$pageRenderer->addPath(__DIR__ . '/../assets/templates/layouts/grid', 'grid');
$pageRenderer->addPath(__DIR__ . '/../includes/classes/Tiles', 'tiles');

// Twig custom functions
$pageRenderer->addGlobalFunction('redirect', [TwigExtension\TwigRedirect::class, 'redirect']);
$pageRenderer->addGlobalFunction('redirectIfLoggedIn', [TwigExtension\TwigRedirect::class, 'redirectIfLoggedIn']);

// Clear action session data
$actionStorage = new WebStorage('action');
$actionStorage->unsetSession();