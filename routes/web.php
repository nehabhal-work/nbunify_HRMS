<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\CompanyController;
use App\Http\Controllers\Master\HeadOfficeController;
use App\Http\Controllers\Master\BranchController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('master')->name('master.')->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('head-offices', HeadOfficeController::class);
    Route::resource('branches', BranchController::class);
});

require __DIR__ . '/settings.php';
