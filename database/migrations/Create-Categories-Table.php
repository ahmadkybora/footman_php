<?php

use Illuminate\Database\Capsule\Manager as Con;

Con::schema()->create('categories', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('slug');
    $table->softDeletes();
    $table->timestamps();
});
