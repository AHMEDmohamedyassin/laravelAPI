<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIcontroller;
use App\Http\Controllers\FetchApi;
use App\Http\Controllers\paymobController;
use App\Http\Controllers\fawryController;


Route::group(['middleware' => 'api'], function () {
    Route::post('login', [APIcontroller::class , 'login']);
    Route::post('register', [APIcontroller::class , 'register']);
    Route::post('logout', [APIcontroller::class , 'logout']);

    Route::post('fetching' , [FetchApi::class , 'index']);

    Route::post('paymob' , [paymobController::class , 'step1']);

    Route::post('fawry' , [fawryController::class , 'index']);
});
