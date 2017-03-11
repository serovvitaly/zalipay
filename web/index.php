<?php

use AppBundle\Repository\PostRepository;
use AppBundle\Repository\RibbonRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

define('APP_DIR', __DIR__.'/..');
define('UID_COOKIE_PARAN_NAME', 'ya_stat_zid');

require_once APP_DIR.'/vendor/autoload.php';

$app = new Application();

$app['uid_generator'] = function () {
    $uid = str_replace('.', '', microtime(true)*2);
    return $uid;
};

/**
 * Определяем, и при необходимости устанавливаем, уникальный идентификатор пользователя
 */
$app->before(function (Request $request, Application $app) {
    $app['UID'] = $request->cookies->get(UID_COOKIE_PARAN_NAME);
    if (empty($app['UID'])) {
        $app['UID'] = $app['uid_generator'];
    }
});
$app->after(function (Request $request, Response $response) use ($app) {
    $coockieExpire = time() + (3600 * 24 * 400);
    $coockie = new Cookie(UID_COOKIE_PARAN_NAME, $app['UID'], $coockieExpire);
    $response->headers->setCookie($coockie);
});

Symfony\Component\Debug\Debug::enable();
$app['debug'] = true;

require_once __DIR__.'/../routes.php';
require_once __DIR__.'/../providers.php';

$app['posts.repository'] = function() use ($app) {
    return new PostRepository($app['db']);
};
$app['ribbons.repository'] = function() use ($app) {
    return new RibbonRepository($app['db']);
};

$app->run();