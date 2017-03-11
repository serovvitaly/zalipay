<?php
/**
 * @var $app \Silex\Application
 */

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
 * Recommender
 */
$app->register(new \services\Recommender\RecommenderServiceProvider(), [
    'app' => $app,
]);

/**
 * Monolog
 * $app['monolog']->debug('Testing the Monolog logging.');
 */
/*$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => APP_DIR.'/logs/development.log',
));*/

/**
 * Mobile detector
 */
$app->register(new \services\MobileDetector\MobileDetectorServiceProvider());

$templatesDir = APP_DIR.'/templates/default';
if ($app['mobile_detector']->isMobile()) {
    $templatesDir = APP_DIR.'/templates/mobile';
}

/**
 * Twig
 */
$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.path' => $templatesDir,
]);