<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardUserController;

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
Route::get('/article', [HomeController::class,'getArtikel']);
Route::get('/article/{url}', [HomeController::class,'getDetailArtikel']);

#auth
Route::get('/login', [UserController::class,'getLogin'])->name('login');
Route::post('/login', [UserController::class,'doLogin']);
Route::get('/register', [UserController::class,'getRegister']);
Route::post('/register', [UserController::class,'submitRegister']);
Route::get('/logout', [UserController::class,'doLogout'])->middleware('auth');

#ajax
Route::post('/getDesa', [AjaxController::class,'getKelurahan'])->middleware('auth');

#dashboard
Route::get('/dashboard/user', [DashboardUserController::class,'index'])->middleware('auth');
Route::get('/biodata', [DashboardUserController::class,'getBiodata'])->middleware('auth');
Route::post('/biodata', [DashboardUserController::class,'submitBiodata'])->middleware('auth');
Route::get('/informed-consent', [DashboardUserController::class,'getConsent'])->middleware('auth');
Route::post('/tandatangan', [DashboardUserController::class,'tandatanganInformedConsent'])->middleware('auth');
Route::get('/foto-gigi', [DashboardUserController::class,'getFotoGigi'])->middleware('auth');
Route::post('/foto-gigi', [DashboardUserController::class,'submitFotoGigi'])->middleware('auth');

#admin
Route::get('/dashboard/admin', [DashboardAdminController::class,'index'])->middleware('auth');
Route::get('/daftar-anak', [DashboardAdminController::class,'getAllAnak'])->middleware('auth');
Route::get('/daftar-anak/detail', [DashboardAdminController::class,'getDetailAnak'])->middleware('auth');
Route::post('/odontogram/submit', [DashboardAdminController::class,'submitOdontogram'])->middleware('auth');
Route::get('/admin/artikel', [DashboardAdminController::class,'getAllArticle'])->middleware('auth');
Route::get('/admin/artikel/new', [DashboardAdminController::class,'getNewArticle'])->middleware('auth');
Route::post('/admin/artikel/new', [DashboardAdminController::class,'submitNewArticle'])->middleware('auth');
Route::get('/admin/artikel/edit', [DashboardAdminController::class,'getEditArticle'])->middleware('auth');
Route::post('/admin/artikel/edit', [DashboardAdminController::class,'submitEditArticle'])->middleware('auth');
Route::get('/admin/artikel/delete', [DashboardAdminController::class,'deleteArticle'])->middleware('auth');