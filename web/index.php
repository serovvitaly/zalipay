<?php

define('APP_DIR', __DIR__.'/..');

require_once APP_DIR.'/vendor/autoload.php';

$app = new Silex\Application();

Symfony\Component\Debug\Debug::enable();
$app['debug'] = true;

/**
 * Config
 */
$app->register(new \services\Config\ConfigServiceProvider(), [
    'config.path' => APP_DIR.'/config.yml',
]);

/**
 * Doctrine
 */
$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => $app['config']['db.options'],
]);

/**
 * Service controller
 */
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

/**
 * Mobile detector
 */
$app->register(new \services\MobileDetector\MobileDetectorServiceProvider());

$templatesDir = APP_DIR.'/templates/default';

if ($app['mobile_detector']->isMobile()) {

    $templatesDir = APP_DIR.'/templates/mobile';
}

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
    'twig.path' => $templatesDir,
));

require_once __DIR__.'/../routes.php';

$app['posts.repository'] = function() use ($app) {
    return new \AppBundle\Repository\PostRepository($app['db']);
};

$app->run();