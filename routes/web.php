<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

Route::get('/', [HomeController::class,'index']);
Route::get('/cara-penggunaan', [HomeController::class,'getCaraPenggunaan']);
Route::get('/artikel', [HomeController::class,'getArtikel']);

#auth
Route::get('/login', [UserController::class,'getLogin']);
Route::get('/register', [UserController::class,'getRegister']);