<?php

define('APP_DIR', __DIR__.'/..');

require_once APP_DIR.'/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

/**
 * Monolog
 * $app['monolog']->debug('Testing the Monolog logging.');
 */
/*$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => APP_DIR.'/logs/development.log',
));*/

/**
 * Twig
 */
$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => APP_DIR.'/templates',
));

$app['debug'] = true;

require_once __DIR__.'/../routes.php';

$app->run();