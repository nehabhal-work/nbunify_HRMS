<?php

use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\DesignationController;
use App\Http\Controllers\Master\EmployeeController;
use App\Http\Controllers\Master\ClientController;
use App\Http\Controllers\Master\ClientFamilyController;
use App\Http\Controllers\Master\SubDepartmentController;
use App\Http\Controllers\Master\SubDesignationController;
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
    Route::resource('departments', DepartmentController::class);
    Route::resource('sub-departments', SubDepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('sub-designations', SubDesignationController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('clients', ClientController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::resource('client-families', ClientFamilyController::class);
});

require __DIR__ . '/settings.php';
