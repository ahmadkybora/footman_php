<?php

namespace App\Providers;

class Redirect extends ServiceProvider
{

    /**
     * redirect to specific page
     * 
     * @param $page
     */
    public static function to($page)
    {
        header("location: $page");
        exit;
    }

    /**
     * redirect to same page
     */
    public static function back()
    {
        $uri = $_SERVER['REQUEST_URI'];
        header("location: $uri");
    }
}