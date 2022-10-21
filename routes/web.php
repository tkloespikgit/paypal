<?php

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
Route::any('receiveNotify', [PaypalController::class, 'receiveNotify']);

