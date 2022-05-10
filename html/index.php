<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bjercke\PageRenderer;

$view = PageRenderer::getInstance();

$view->render();