<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PUBLIC CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\EmployeeController as PublicEmployeeController;


/*
|--------------------------------------------------------------------------
| AUTH CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Admin\EmployeeDocumentController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\SalarySlipController;
use App\Http\Controllers\Admin\WhatsAppController;


/*
|--------------------------------------------------------------------------
| PUBLIC AREA
|--------------------------------------------------------------------------
| Semua halaman di bagian ini dapat diakses tanpa login.
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', [
    HomeController::class,
    'index'
])->name('public.home');


/*
|--------------------------------------------------------------------------
| DATA KARYAWAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/karyawan', [
    PublicEmployeeController::class,
    'index'
])->name('public.employees');


/*
|--------------------------------------------------------------------------
| FOTO KARYAWAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/karyawan/{employee}/foto', [
    PublicEmployeeController::class,
    'photo'
])->name('public.employee.photo');


/*
|--------------------------------------------------------------------------
| DETAIL KARYAWAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/karyawan/{employee}', [
    PublicEmployeeController::class,
    'show'
])->name('public.employee.show');


/*
|--------------------------------------------------------------------------
| DOKUMEN KARYAWAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/dokumen/{document}/lihat', [
    PublicEmployeeController::class,
    'document'
])->name('public.document.viewer');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [
        LoginController::class,
        'showLoginForm'
    ])->name('login');


    Route::post('/login', [
        LoginController::class,
        'login'
    ])->name('login.process');

});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [
    LoginController::class,
    'logout'
])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
| Semua route di bawah:
| - wajib login
| - wajib role admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'employees',
            AdminEmployeeController::class
        );


        /*
        |--------------------------------------------------------------------------
        | DOKUMEN KARYAWAN
        |--------------------------------------------------------------------------
        */

        Route::get('/documents', [
            EmployeeDocumentController::class,
            'index'
        ])->name('documents.index');


        Route::get('/documents/create', [
            EmployeeDocumentController::class,
            'create'
        ])->name('documents.create');


        Route::post('/documents', [
            EmployeeDocumentController::class,
            'store'
        ])->name('documents.store');


        Route::get('/documents/{document}/edit', [
            EmployeeDocumentController::class,
            'edit'
        ])->name('documents.edit');


        Route::put('/documents/{document}', [
            EmployeeDocumentController::class,
            'update'
        ])->name('documents.update');


        Route::delete('/documents/{document}', [
            EmployeeDocumentController::class,
            'destroy'
        ])->name('documents.destroy');


        Route::get('/documents/{document}/view', [
            EmployeeDocumentController::class,
            'view'
        ])->name('documents.view');


        /*
        |--------------------------------------------------------------------------
        | PELATIHAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'trainings',
            TrainingController::class
        );


        /*
        |--------------------------------------------------------------------------
        | PENGHARGAAN / PMP / MEDALI
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'awards',
            AwardController::class
        );


        /*
        |--------------------------------------------------------------------------
        | SLIP GAJI
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | DAFTAR SLIP GAJI
        |--------------------------------------------------------------------------
        */

        Route::get('/salary-slips', [
            SalarySlipController::class,
            'index'
        ])->name('salary-slips.index');


        /*
        |--------------------------------------------------------------------------
        | FORM UPLOAD SLIP GAJI
        |--------------------------------------------------------------------------
        */

        Route::get('/salary-slips/upload', [
            SalarySlipController::class,
            'create'
        ])->name('salary-slips.upload');


        /*
        |--------------------------------------------------------------------------
        | SIMPAN SLIP GAJI
        |--------------------------------------------------------------------------
        */

        Route::post('/salary-slips', [
            SalarySlipController::class,
            'store'
        ])->name('salary-slips.store');


        /*
        |--------------------------------------------------------------------------
        | PROSES WATERMARK
        |--------------------------------------------------------------------------
        |
        | PDF original
        |      ↓
        | WatermarkService
        |      ↓
        | PDF watermarked
        |
        */

        Route::post('/salary-slips/{salarySlip}/process-watermark', [
            SalarySlipController::class,
            'processWatermark'
        ])->name('salary-slips.process-watermark');


        /*
        |--------------------------------------------------------------------------
        | LIHAT PDF WATERMARK
        |--------------------------------------------------------------------------
        */

        Route::get('/salary-slips/{salarySlip}/view-watermarked', [
            SalarySlipController::class,
            'viewWatermarked'
        ])->name('salary-slips.view-watermarked');


        /*
        |--------------------------------------------------------------------------
        | PREVIEW PDF ORIGINAL
        |--------------------------------------------------------------------------
        */

        Route::get('/salary-slips/{salarySlip}/view', [
            SalarySlipController::class,
            'view'
        ])->name('salary-slips.view');


        /*
        |--------------------------------------------------------------------------
        | DETAIL SLIP GAJI
        |--------------------------------------------------------------------------
        */

        Route::get('/salary-slips/{salarySlip}', [
            SalarySlipController::class,
            'show'
        ])->name('salary-slips.show');


        /*
        |--------------------------------------------------------------------------
        | HAPUS SLIP GAJI
        |--------------------------------------------------------------------------
        */

        Route::delete('/salary-slips/{salarySlip}', [
            SalarySlipController::class,
            'destroy'
        ])->name('salary-slips.destroy');


        /*
        |--------------------------------------------------------------------------
        | KIRIM SLIP GAJI VIA WHATSAPP
        |--------------------------------------------------------------------------
        |
        | Untuk sementara route ini tetap ada.
        | Nanti controller WhatsApp akan kita ubah agar hanya
        | mengirim PDF yang sudah diberi watermark.
        |
        */

        Route::post('/salary-slips/{salarySlip}/send-whatsapp', [
            WhatsAppController::class,
            'sendSalarySlip'
        ])->name('salary-slips.send-whatsapp');


        /*
        |--------------------------------------------------------------------------
        | SHORTCUT KIRIM SLIP GAJI
        |--------------------------------------------------------------------------
        */

        Route::post('/employees/{employee}/send-salary-slip', [
            WhatsAppController::class,
            'sendLatestSalarySlip'
        ])->name('employees.send-salary-slip');

    });