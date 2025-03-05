<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SettingsController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

// USER KARYAWAN
route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    route::post('/proseslogin', [AuthController::class,'proseslogin']); 
    
});

// USER ADMIN
route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    route::post('/prosesloginadmin', [AuthController::class,'prosesloginadmin']);
    
});

route::middleware(['auth:karyawan'])->group(function () {
    route::get('/dashboard', [DashboardController::class, 'index']);
    route::get('/proseslogout', [AuthController::class,'proseslogout']);

    //Presensi
    Route::get('/presensi/create', [PresensiController::class,'create']);
    
    // takeabsen
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    //edit profile
    Route::get('/editProfile', [PresensiController::class,'editProfile']);
    Route::post('/presensi/{nrp}/updateProfile', [PresensiController::class, 'updateProfile']);
    
    // Histori Absen    
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/getHistori', [PresensiController::class, 'getHistori']);

    // CIS
    Route::get('/presensi/izin',[PresensiController::class,'izin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin', [AuthController::class,'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin',[DashboardController::class,'dashboardAdmin']);

    // Data master Karyawan
    // Route::get('/panel/karyawan',[KaryawanController::class,'karyawanInfo']);
    Route::get('/panel/karyawan',[KaryawanController::class,'index']);
    Route::post('/panel/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/panel/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/panel/karyawan/{nrp}/update', [KaryawanController::class, 'update']);
    Route::post('/panel/karyawan/{nrp}/delete', [KaryawanController::class, 'delete']);
    
    // Data master Department
    Route::get('/panel/department', [DepartmentController::class,'index']);
    Route::post('/panel/department/store', [DepartmentController::class,'store']);
    Route::post('/panel/department/edit', [DepartmentController::class,'edit']);
    Route::post('/panel/department/{kode_dept}/update', [DepartmentController::class,'update']);
    Route::post('/panel/department/{kode_dept}/delete', [DepartmentController::class,'delete']);

    // Presensi
    Route::get('/panel/presensi/monitoring', [PresensiController::class,'monitoring']);
    Route::post('/getpresensi', [PresensiController::class,'getPresensi']);
    Route::post('/showlocation', [PresensiController::class,'showLocation']);
    Route::get('/panel/report', [PresensiController::class,'report']);
    Route::post('/presensi/cetakReport', [PresensiController::class,'cetakReport']);
    Route::get('/panel/rekapReport', [PresensiController::class,'rekapReport']);
    Route::post('/presensi/cetakRekap', [PresensiController::class,'cetakRekap']);

    // Settings
    Route::get('/settings/lokasi/radius',[SettingsController::class,'radius']);
    Route::post('/settings/lokasi/radius/update',[SettingsController::class,'updateRadius']);
    Route::get('/settings/jamKerja',[SettingsController::class,'jamKerja']);
});

