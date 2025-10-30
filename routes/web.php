<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('dashboard', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/', function () {
    return view('Dashboard');
});

require __DIR__ . '/settings.php';


Route::prefix('master')->name('master.')->group(function () {

    Route::resource('companies', CompanyController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('cp', CpController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('head-offices', HeadOfficeController::class);
    Route::resource('references', ReferenceController::class);
});
