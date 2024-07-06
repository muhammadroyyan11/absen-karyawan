<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;

//admin
use App\Http\Controllers\Admin\PanelAdminController;
use App\Http\Controllers\Admin\RekapAdminController;
use App\Http\Controllers\Admin\CutiAdminController;

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

Route::middleware(['guest:web'])->group(function (){
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/prosesLogin', [AuthController::class, 'prosesLogin']);
});

Route::middleware(['guest:user'])->group(function (){
    Route::get('/admin', function (){
       return view('auth.loginAdmin');
    })->name('login-admin');
    Route::post('/prosesLoginAdmin', [AuthController::class, 'prosesLoginAdmin']);
});


Route::middleware(['auth:user'])->group(function (){
    Route::get('/panel-admin', [PanelAdminController::class, 'index']);
    Route::get('/logoutAdmin', [AuthController::class, 'logoutAdmin']);

    Route::get('/rekap-absen', [RekapAdminController::class, 'index']);
    Route::get('/request-cuti-list', [CutiAdminController::class, 'index']);
    Route::get('/history-cuti-list', [CutiAdminController::class, 'history']);
});


Route::middleware(['auth:web'])->group(function (){
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    //edit profile
    Route::get('/edit-profile', [PresensiController::class, 'editProfile']);
    Route::post('/presensi/{id}/update-profile', [PresensiController::class, 'updateProfile']);

    //history
    Route::get('/history', [PresensiController::class, 'history']);
    Route::post('/get-history', [PresensiController::class, 'getHistory']);

    //cuti / izin
    Route::get('/presensi/cuti', [PresensiController::class, 'cuti']);
    Route::get('/presensi/cuti/create', [PresensiController::class, 'create_cuti']);
    Route::post('/presensi/cuti/store', [PresensiController::class, 'store_cuti']);
});
//Route::get('/dashboard', [DashboardController::class, 'index']);
//Route::group(['prefix'=>'page','as'=>'page.'], function(){
//    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
//})->middleware('auth');
