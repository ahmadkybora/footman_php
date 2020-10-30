<?php

/**
 * start session if not already started
 */
if(!isset($_SESSION))
    session_start();

/**
 * this statement for create database table
 */
//require_once __DIR__ . '/../database/migrations/Create-Categories-Table.php';
//require_once __DIR__ . '/../database/migrations/Create-Users-Table.php';

/**
 * load environment variable
 */
require_once __DIR__.'/../config/database.php';

/**
 * this instance for connection
 */
new App\Providers\Connection();

/**
 * set custom error handler
 */
set_error_handler([new \App\Exceptions\ErrorHandler(), 'handleErrors']);

/**
 * load directory web
 */
require_once __DIR__.'/../routes/web.php';
require_once __DIR__.'/../routes/front.php';
require_once __DIR__.'/../routes/panel.php';

/**
 * this instance for router
 */
new \App\Providers\BaseRoute($router);