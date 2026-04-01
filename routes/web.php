<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Masters\BranchController;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\HeadOfficeController;
use App\Http\Controllers\googleDrive\GoogleDriveController;
use App\Http\Controllers\Settings\UserManagementController;
use App\Http\Controllers\Settings\RolePermissionViewController;

// MERGED
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/upload-temp', [App\Http\Controllers\TempUploadController::class, 'store'])->name('upload.temp');

Route::middleware(['auth', 'verified'])->prefix('master')->name('master.')->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::delete('companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('permission:companies.delete');
    Route::resource('head-offices', HeadOfficeController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('departments', DepartmentController::class);
});



Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');
require __DIR__ . '/settings.php';
