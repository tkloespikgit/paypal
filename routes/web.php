<?php

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
Route::get('/',[\App\Http\Controllers\Payment\PaypalController::class,'renderHtml']);
Route::post('/',[\App\Http\Controllers\Payment\PaypalController::class,'pay']);
Route::any('receiveNotify',[\App\Http\Controllers\Payment\PaypalController::class,'receiveNotify']);

###### visa/mastercard
Route::get('creditCard',[\App\Http\Controllers\Payment\StripeController::class,'renderHtml']);
Route::post('creditCard',[\App\Http\Controllers\Payment\StripeController::class,'pay']);
Route::any('creditCard/receiveNotify',[\App\Http\Controllers\Payment\StripeController::class,'receiveNotify']);
Route::any('creditCard/success',[\App\Http\Controllers\Payment\StripeController::class,'success']);

Route::any('showLic',[\App\Http\Controllers\Controller::class,'ShowLic']);
Route::any('showBill/{order_number}',[\App\Http\Controllers\Controller::class,'ShowBill']);
Route::any('showInvoice/{email}',[\App\Http\Controllers\Controller::class,'ShowInvoice']);
Route::any('success',[\App\Http\Controllers\Controller::class,'success']);
