<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Payment\PaypalController;
use Illuminate\Support\Facades\Route;

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

###### paypal
Route::get('/', [PaypalController::class, 'renderHtml']);
Route::post('/', [PaypalController::class, 'pay']);
Route::get('/paypal/{order_no}', [PaypalController::class, 'redirectHtml']);
Route::any('receiveNotify', [PaypalController::class, 'receiveNotify']);

Route::get('orderDetails/{id}',[OrderController::class,'orderDetail']);
Route::any('Gateway/ReceiveNotify/Ayden',[OrderController::class,'aydenNotify']);
