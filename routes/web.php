<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;

//admin
use App\Http\Controllers\admin\PanelAdminController;
use App\Http\Controllers\admin\RekapAdminController;
use App\Http\Controllers\admin\CutiAdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\admin\GroamingStaffController;
use App\Http\Controllers\admin\JadwalInputController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\CutiRequestController;

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
Route::middleware(['auth', 'check.session'])->group(function () {
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
    Route::post('/get-history-calendar', [PresensiController::class, 'getHistoryCalendar']);
    Route::post('/get-presensi-detail', [PresensiController::class, 'getPresensiDetail']);

    //jadwal
    Route::get('/jadwal', [JadwalController::class, 'index']);
    Route::post('/get-jadwal', [JadwalController::class, 'getHistory']);
    Route::post('/get-jadwal-calendar', [JadwalController::class, 'getJadwalCalendar']);

    //cuti / izin
    Route::get('/presensi/cuti', [PresensiController::class, 'cuti']);
    Route::get('/presensi/cuti/create', [PresensiController::class, 'create_cuti']);
    Route::post('/presensi/cuti/store', [PresensiController::class, 'store_cuti']);
});

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

    //input jadwal
    Route::get('/jadwal-input', [\App\Http\Controllers\admin\JadwalInputController::class, 'index']);
    Route::get('/get-data-jadwal', [\App\Http\Controllers\admin\JadwalInputController::class, 'getDatatables']);
    Route::get('/jadwal/export-template', [JadwalInputController::class, 'exportTemplate']);
    Route::post('/jadwal/import', [JadwalInputController::class, 'import'])->name('jadwal.import');

    //foto groaming drive
    Route::get('/rekap-groaming', [GroamingStaffController::class, 'index']);
    Route::get('/groaming/folder/{year}', [GroamingStaffController::class, 'showMonths'])->name('groaming.folder');
    Route::get('/groaming/folder/{year}/{month}', [GroamingStaffController::class, 'showDates']);
    Route::get('/groaming/folder/{year}/{month}/{day}', [GroamingStaffController::class, 'showPhotos']);

    // groaming recap
    Route::prefix('admin/presensi-drive')->group(function () {
        Route::get('/', [GroamingStaffController::class, 'driveYears'])->name('drive.years');
        Route::get('/{year}', [GroamingStaffController::class, 'driveMonths'])->name('drive.months');
        Route::get('/{year}/{month}', [GroamingStaffController::class, 'driveDates'])->name('drive.dates');
        Route::get('/{year}/{month}/{day}', [GroamingStaffController::class, 'driveStaff'])->name('drive.staff');
        Route::get('/{year}/{month}/{day}/{user}', [GroamingStaffController::class, 'drivePhotos'])->name('drive.photos');
    });

    // department route
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/data', [DepartmentController::class, 'getDatatables'])->name('departments.data');
    Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::post('/departments/{id}/update', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}/delete', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::post('/departments/assign-users', [DepartmentController::class, 'assignUsers'])->name('departments.assignUsers');

    // Approval Cuti Request route
    Route::get('/cuti', [CutiRequestController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/data', [CutiRequestController::class, 'getDatatables'])->name('cuti.data');
    Route::post('/cuti/store', [CutiRequestController::class, 'store'])->name('cuti.store');
    Route::get('/cuti/{id}/edit', [CutiRequestController::class, 'edit'])->name('cuti.edit');
    Route::post('/cuti/{id}/update', [CutiRequestController::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{id}/delete', [CutiRequestController::class, 'destroy'])->name('cuti.destroy');
    Route::post('/cuti/assign-users', [CutiRequestController::class, 'assignUsers'])->name('cuti.assignUsers');

    Route::get('/rekap-absen', [RekapAdminController::class, 'index']);
    Route::get('/request-cuti-list', [CutiAdminController::class, 'index']);
    Route::get('/history-cuti-list', [CutiAdminController::class, 'history']);
});


//Route::middleware(['auth:web'])->group(function (){
//
//});
//Route::get('/dashboard', [DashboardController::class, 'index']);
//Route::group(['prefix'=>'page','as'=>'page.'], function(){
//    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
//})->middleware('auth');
