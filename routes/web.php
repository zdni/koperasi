<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmploymentContractController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;



Route::get('/', function () { return redirect('/login'); });

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::middleware([Authenticate::class])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/beranda', [DashboardController::class, 'index']);
    
    Route::get('/karyawan', [EmployeeController::class, 'index']);
    Route::get('/karyawan/buat', [EmployeeController::class, 'create']);
    Route::post('/karyawan', [EmployeeController::class, 'store']);
    Route::put('/karyawan/ubah-status/{employee}', [EmployeeController::class, 'change_activity_state']);
    Route::get('/karyawan/ubah/{employee}', [EmployeeController::class, 'edit']);
    Route::get('/karyawan/kontrak/{employee}', [EmployeeController::class, 'redirect_to_employee_contract_detail']);
    Route::get('/karyawan/{employee}', [EmployeeController::class, 'show']);
    Route::put('/karyawan/{employee}', [EmployeeController::class, 'update']);
    Route::get('/karyawan-nonaktif', [EmployeeController::class, 'ex_exmployees']);

    Route::get('/dana-jht', [AccountController::class, 'index']);
    Route::post('/buat-jht', [AccountController::class, 'store']);
    Route::put('/dana-jht/{account}', [AccountController::class, 'update']);
    Route::get('/detail-jht/{account}', [AccountController::class, 'show']);
    Route::get('/input-jht/{account}', [AccountController::class, 'edit']);
    Route::put('/batalkan-jht/{account}', [AccountController::class, 'cancel']);
    Route::put('/validasi-jht/{account}', [AccountController::class, '_validate']);
    
    Route::put('/manajemen/wilayah/atur-adm-wilayah', [RegionController::class, 'set_region_leaderships']);
    Route::resource('/manajemen/wilayah', RegionController::class);

    Route::resource('/manajemen/unit', UnitController::class);

    Route::resource('/manajemen/jabatan', PositionController::class);
    
    Route::get('/manajemen/pengguna/alihkan-ke-karyawan', [UserController::class, 'redirect_to_employee']);
    Route::resource('/manajemen/pengguna', UserController::class);

    Route::post('/kontrak-kerja', [EmploymentContractController::class, 'store']);
    Route::put('/kontrak-kerja/{employmentContract}', [EmploymentContractController::class, 'update']);

    Route::get('/laporan/karyawan-aktif', [ReportController::class, 'report']);
    Route::post('/laporan/karyawan-aktif', [ReportController::class, 'get_active_employee_fund_report']);
    Route::post('/laporan/karyawan-nonaktif', [ReportController::class, 'get_inactive_employee_fund_report']);
    
});