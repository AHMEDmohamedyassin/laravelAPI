<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\paymobController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/callback' , [paymobController::class , 'processed']);
Route::get('/callback' , [paymobController::class , 'response']);
