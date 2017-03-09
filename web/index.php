<?php

define('APP_DIR', __DIR__.'/..');

require_once APP_DIR.'/vendor/autoload.php';

$app = new Silex\Application();

Symfony\Component\Debug\Debug::enable();
$app['debug'] = true;

require_once __DIR__.'/../routes.php';
require_once __DIR__.'/../providers.php';

$app['posts.repository'] = function() use ($app) {
    return new \AppBundle\Repository\PostRepository($app['db']);
};

$app->run();