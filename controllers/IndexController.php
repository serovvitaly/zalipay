<?php

namespace controllers;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->app['twig']->render('index.html', array(
            'wrapper_widget' => 'widget/multi-column.html',
            'items_by_columns' => ['items'=>[]],
            'item' => [],
            'is_editor' => false,
        ));
    }
}