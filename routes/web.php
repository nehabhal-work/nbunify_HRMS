<?php

use App\Http\Controllers\Accounts\ExpensesController;
use App\Http\Controllers\Accounts\LedgerController;
use App\Http\Controllers\Accounts\purchaseController;
use App\Http\Controllers\Accounts\PurchaseOrderController;
use App\Http\Controllers\Accounts\salesController;
use App\Http\Controllers\Accounts\VendorsController;
use App\Http\Controllers\Investment\ElsInvestmentController;
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

Route::middleware(['auth', 'verified'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::resource('vendors', VendorsController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('sales', salesController::class);
    Route::resource('purchase-order', PurchaseOrderController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('ledger', LedgerController::class);
});

Route::middleware(['auth', 'verified'])->prefix('investment')->name('investment.')->group(function () {
    Route::resource('els-investment', ElsInvestmentController::class);
});
require __DIR__ . '/settings.php';
