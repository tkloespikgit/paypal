<?php

use App\Admin\Controllers\HomeController;
use App\Admin\Controllers\OrderController;
use App\Admin\Controllers\PaypalAccountController;
use App\Admin\Controllers\ProductController;
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'middleware' => config('admin.route.middleware'),
    'as'         => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', [HomeController::class, 'index'])->name('home');

    $router->resource('paypal-accounts', PaypalAccountController::class);
    $router->resource('order-infos', OrderController::class);
    $router->resource('products', ProductController::class);
});
