<?php

$router = new AltoRouter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//$router->map('GET', '/featured', 'App\Controllers\Front\Dashboard\DashboardController@index');
/**
 * this route for dashboard
 */
$router->map('GET', '/admin/dashboard',
    'App\Controllers\Panel\Dashboard\DashboardController@index', 'dashboard-index');
$router->map('POST', '/admin/dashboard',
    'App\Controllers\Panel\Dashboard\DashboardController@store', 'dashboard-store');

/**
 * this route for user
 */
$router->map('GET', '/panel/users',
    'App\Controllers\Panel\User\UserController@index', 'users');

/**
 * this routes for product categories
 */
$router->map('GET', '/admin/product/categories',
    'App\Controllers\Panel\Category\ProductCategoryController@index', 'all-product-category-index');

$router->map('GET', '/admin/product/categories/create',
    'App\Controllers\Panel\Category\ProductCategoryController@create', 'make-product-category');

$router->map('POST', '/admin/product/categories/store',
    'App\Controllers\Panel\Category\ProductCategoryController@store', 'create-product-category-store');

$router->map('GET', '/admin/product/categories/[i:id]/show',
    'App\Controllers\Panel\Category\ProductCategoryController@show', 'show-product-category');

$router->map('GET', '/admin/product/categories/[i:id]/edit',
    'App\Controllers\Panel\Category\ProductCategoryController@edit', 'edit-product-category-edit');

$router->map('POST', '/admin/product/categories/[i:id]/update',
    'App\Controllers\Panel\Category\ProductCategoryController@update', 'update-product-category');

$router->map('POST', '/admin/product/categories/[i:id]/delete',
    'App\Controllers\Panel\Category\ProductCategoryController@destroy', 'destroy-product-category');

/**
 * this routes for product categories
 */
$router->map('GET', '/admin/product/subcategories/create',
    'App\Controllers\Panel\Category\SubCategoryController@create', 'make-sub-category');

/**
 * this route for site
 */
$router->map('GET', '/', 'App\Controllers\Panel\Dashboard\DashboardController@index', 'home');


$router->map('POST', '/cart', 'App\Controllers\Front\Profile\CartController@addToCart', 'add-to-cart');
$router->map('GET', '/cart', 'App\Controllers\Front\Profile\CartController@show', 'show-cart');
$router->map('GET', '/cart/items', 'App\Controllers\Front\Profile\CartController@getCart', 'get-cart');
$router->map('POST', '/cart/update-qty', 'App\Controllers\Front\Profile\CartController@updateQuantity', 'cart-update-Quantity');
$router->map('POST', '/cart/remove-item', 'App\Controllers\Front\Profile\CartController@removeFromCart', 'remove-from-cart');
$router->map('POST', '/cart/payment', 'App\Controllers\Auth\CartController@checkout', 'handle-payment');



$router->map('GET', '/register', 'App\Controllers\Auth\CartController@showRegisterForm', 'register');
$router->map('POST', '/register', 'App\Controllers\Auth\CartController@register', 'register-post');

$router->map('GET', '/login', 'App\Controllers\Auth\CartController@showLoginForm', 'login');
$router->map('POST', '/login', 'App\Controllers\Auth\CartController@login', 'login-post');

$router->map('POST', '/logout', 'App\Controllers\Auth\CartController@logout', 'logout');


$router->map('POST', '/paypal/create-payment', 'App\Controllers\Front\CartController@paypalCreatePayment', 'create-payment');
$router->map('POST', '/paypal/execute-payment', 'App\Controllers\Front\CartController@paypalExecutePayment', 'execute-payment');


$router->map('GET', 'admin/transactions/orders', 'App\Controllers\Panel\OrderController@show');