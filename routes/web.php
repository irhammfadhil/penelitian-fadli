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

Route::get('/dummy', [DashboardAdminController::class,'dummy']);

Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('/cara-penggunaan', [HomeController::class,'getCaraPenggunaan']);
Route::get('/article', [HomeController::class,'getArtikel']);
Route::get('/article/{url}', [HomeController::class,'getDetailArtikel']);

#auth
Route::get('/login', [UserController::class,'getLogin'])->name('login');
Route::post('/login', [UserController::class,'doLogin']);
Route::get('/register', [UserController::class,'getRegister']);
Route::post('/register', [UserController::class,'submitRegister']);
Route::get('/logout', [UserController::class,'doLogout'])->middleware('auth');
Route::get('/change-password', [UserController::class,'getChangePassword'])->middleware('auth');
Route::post('/change-password', [UserController::class,'submitChangePassword'])->middleware('auth');

#ajax
Route::post('/getDesa', [AjaxController::class,'getKelurahan'])->middleware('auth');

#dashboard
Route::get('/dashboard/user', [DashboardUserController::class,'index'])->middleware('auth');
Route::get('/biodata', [DashboardUserController::class,'getBiodata'])->middleware('auth');
Route::post('/biodata', [DashboardUserController::class,'submitBiodata'])->middleware('auth');
Route::get('/screening-covid', [DashboardUserController::class,'getScreeningCovid'])->middleware('auth');
Route::post('/screening-covid', [DashboardUserController::class,'screeningCovid'])->middleware('auth');
Route::get('/informed-consent', [DashboardUserController::class,'getConsent'])->middleware('auth');
Route::post('/tandatangan', [DashboardUserController::class,'tandatanganInformedConsent'])->middleware('auth');
Route::get('/foto-gigi', [DashboardUserController::class,'getFotoGigi'])->middleware('auth');
Route::post('/foto-gigi', [DashboardUserController::class,'submitFotoGigi'])->middleware('auth');
Route::get('/komentar', [DashboardUserController::class,'getKomentar'])->middleware('auth');
Route::get('/finalisasi', [DashboardUserController::class,'getFinalisasi'])->middleware('auth');
Route::get('/finalisasi/submit', [DashboardUserController::class,'submitFinalisasi'])->middleware('auth');

#admin
Route::get('/dashboard/admin', [DashboardAdminController::class,'index'])->middleware('auth');
Route::get('/daftar-anak', [DashboardAdminController::class,'getAllAnak'])->middleware('auth');
Route::get('/daftar-anak/detail', [DashboardAdminController::class,'getDetailAnak'])->middleware('auth');
Route::get('/daftar-anak/detail/edit', [DashboardAdminController::class,'getEditData'])->middleware('auth');
Route::post('/daftar-anak/detail/edit', [DashboardAdminController::class,'submitEditData'])->middleware('auth');
Route::get('/daftar-anak/delete', [DashboardAdminController::class,'deleteAnak'])->middleware('auth');
Route::get('/daftar-anak/cetak-consent', [DashboardAdminController::class,'cetakInformedConsent'])->middleware('auth');
Route::get('/daftar-anak/cetak-laporan', [DashboardAdminController::class,'cetakLaporan'])->middleware('auth');
Route::get('/daftar-user', [DashboardAdminController::class,'getAllUsers'])->middleware('auth');
Route::get('/daftar-user/makeAdmin', [DashboardAdminController::class,'makeAdmin'])->middleware('auth');
Route::get('/daftar-user/makeUser', [DashboardAdminController::class,'makeUser'])->middleware('auth');
Route::post('/odontogram/submit', [DashboardAdminController::class,'submitOdontogram'])->middleware('auth');
Route::get('/admin/artikel', [DashboardAdminController::class,'getAllArticle'])->middleware('auth');
Route::get('/admin/artikel/new', [DashboardAdminController::class,'getNewArticle'])->middleware('auth');
Route::post('/admin/artikel/new', [DashboardAdminController::class,'submitNewArticle'])->middleware('auth');
Route::get('/admin/artikel/edit', [DashboardAdminController::class,'getEditArticle'])->middleware('auth');
Route::post('/admin/artikel/edit', [DashboardAdminController::class,'submitEditArticle'])->middleware('auth');
Route::get('/admin/artikel/delete', [DashboardAdminController::class,'deleteArticle'])->middleware('auth');
Route::post('/admin/submitFoto', [DashboardAdminController::class,'inputKomentarFotoAdmin'])->middleware('auth');
Route::post('/admin/submitKomentar', [DashboardAdminController::class,'submitKomentar'])->middleware('auth');
##report
Route::get('/report', [DashboardAdminController::class,'generateReportGeneral'])->name('report')->middleware('auth');
Route::get('/report/bySchool', [DashboardAdminController::class,'generateReportBySchool'])->name('reportBySchool')->middleware('auth');
Route::post('/report/bySchool', [DashboardAdminController::class,'submitgenerateReportBySchool'])->name('reportBySchoolSubmit')->middleware('auth');
Route::get('/report/responden', [DashboardAdminController::class,'generateReportGeneral'])->name('report-responden')->middleware('auth');
Route::get('/report/dmft', [DashboardAdminController::class,'generateReportGeneral'])->name('report-dmft')->middleware('auth');
Route::get('/report/deft', [DashboardAdminController::class,'generateReportGeneral'])->name('report-deft')->middleware('auth');
Route::get('/report/rti', [DashboardAdminController::class,'generateReportGeneral'])->name('report-rti')->middleware('auth');
Route::get('/report/bySchool/responden', [DashboardAdminController::class,'generateReportBySchool'])->name('reportBySchool-responden')->middleware('auth');
Route::get('/report/bySchool/dmft', [DashboardAdminController::class,'generateReportBySchool'])->name('reportBySchool-dmft')->middleware('auth');
Route::get('/report/bySchool/deft', [DashboardAdminController::class,'generateReportBySchool'])->name('reportBySchool-deft')->middleware('auth');
Route::get('/report/bySchool/rti', [DashboardAdminController::class,'generateReportBySchool'])->name('reportBySchool-rti')->middleware('auth');