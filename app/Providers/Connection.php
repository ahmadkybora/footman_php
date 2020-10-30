<?php

namespace App\Providers;

use Illuminate\Database\Capsule\Manager as Con;

class Connection extends ServiceProvider
{
    public function __construct()
    {
        $db = new Con;
        $db->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $db->setAsGlobal();
        $db->bootEloquent();
    }
}