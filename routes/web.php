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

Route::any('/',[\App\Http\Controllers\Controller::class,'showAccounts']);
Route::any('showAccountsV2',[\App\Http\Controllers\Controller::class,'showAccountsV2']);
Route::any('make-payment',[\App\Http\Controllers\Controller::class,'payNow']);
Route::any('receiveNotify',[\App\Http\Controllers\Controller::class,'ReceiveNotify']);
