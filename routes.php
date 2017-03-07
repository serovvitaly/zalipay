<?php

$app['posts.controller'] = function($app) {
    return new \controllers\IndexController($app);
};

$app->get('/', 'posts.controller:actionIndex');