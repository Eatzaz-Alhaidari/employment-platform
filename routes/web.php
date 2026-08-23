<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ApplicantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Application Routes (Google-Form style)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('applicant.create');
});

Route::get('/apply', [ApplicantController::class, 'create'])->name('applicant.create');
Route::post('/apply', [ApplicantController::class, 'store'])->name('applicant.store');
Route::get('/apply/success/{applicant}', [ApplicantController::class, 'success'])->name('applicant.success');

/*
|--------------------------------------------------------------------------
| Admin Management Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/applicants/{applicant}', [DashboardController::class, 'show'])->name('applicants.show');
    Route::patch('/applicants/{applicant}/status', [DashboardController::class, 'updateStatus'])->name('applicants.update_status');
    Route::get('/applicants/{applicant}/cv', [DashboardController::class, 'downloadCv'])->name('applicants.cv');
    Route::get('/applicants/{applicant}/id-doc', [DashboardController::class, 'downloadId'])->name('applicants.id_doc');
    Route::delete('/applicants/{applicant}', [DashboardController::class, 'destroy'])->name('applicants.destroy');
});
