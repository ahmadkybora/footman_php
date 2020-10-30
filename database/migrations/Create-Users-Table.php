<?php

use Illuminate\Database\Capsule\Manager as Con;

Con::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('password');
    $table->softDeletes();
    $table->timestamps();
});
