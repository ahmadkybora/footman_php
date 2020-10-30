<?php

use Stripe\Stripe;
use App\Providers\Session;
$stripe = array(
    'secret_key' => getenv('STRIPE_SECRET'),
    'publisher_key' => getenv('STRIPE_PUBLISHER_KEY'),
);

Session::add('publisher_key', $stripe['publisher_key']);
Stripe::setApiKey($stripe['secret_key']);