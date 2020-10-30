<?php

$router = new AltoRouter;

/**
 * this route for dashboard
 */
$router->map('GET', '/admin/dashboard',
    'App\Controllers\Panel\Dashboard\DashboardController@index', 'dashboard-index');
$router->map('POST', '/admin/dashboard',
    'App\Controllers\Panel\Dashboard\DashboardController@store', 'dashboard-store');