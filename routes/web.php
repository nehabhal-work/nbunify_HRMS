<?php

use App\Http\Controllers\Accounts\ExpensesController;
use App\Http\Controllers\Accounts\LedgerController;
use App\Http\Controllers\Accounts\purchaseController;
use App\Http\Controllers\Accounts\PurchaseOrderController;
use App\Http\Controllers\Accounts\salesController;
use App\Http\Controllers\Accounts\VendorsController;
use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\DesignationController;
use App\Http\Controllers\Masters\EmployeeController;
use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\Clients\ClientFamilyController;
use App\Http\Controllers\Masters\SubDepartmentController;
use App\Http\Controllers\Masters\SubDesignationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\Masters\HeadOfficeController;
use App\Http\Controllers\Masters\BranchController;

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
    Route::get('client-families/family/create/{client?}', [ClientFamilyController::class, 'create'])->name('client-families.create');
    Route::get('client-families/client/{client}', [ClientFamilyController::class, 'index'])->name('client-families.index');
});

Route::middleware(['auth', 'verified'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::resource('vendors', VendorsController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', salesController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('ledger', LedgerController::class);
});

Route::middleware(['auth', 'verified'])->prefix('investment')->name('investment.')->group(function () {
    Route::resource('els-investment', ElsInvestmentController::class);
});
require __DIR__ . '/settings.php';
