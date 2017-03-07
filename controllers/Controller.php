<?php

namespace controllers;


class Controller
{
    protected $app;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }
}