<?php

namespace App\Providers;

use Philo\Blade\Blade;

class View extends ServiceProvider
{
    /**
     * this method for make view in directory resources
     * @param $path
     * @param array $data
     */
    public static function view($path, array $data = [])
    {
        $view = __DIR__ . '/../../resources/views';
        $catch = __DIR__ . '/../../bootstrap/cache';

        $blade = new Blade($view, $catch);
        echo $blade->view()->make($path, $data)->render();
    }
}