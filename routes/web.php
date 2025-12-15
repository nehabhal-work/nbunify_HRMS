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
use App\Http\Controllers\Clients\ClientBankController;
use App\Http\Controllers\Clients\ClientBDayController;
use App\Http\Controllers\Investment\InvestmentController;
use App\Http\Controllers\Investment\SchemeController;
use App\Http\Controllers\Masters\SubDepartmentController;
use App\Http\Controllers\Masters\SubDesignationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\Masters\HeadOfficeController;
use App\Http\Controllers\Masters\BranchController;


// MERGED
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
    Route::get('employees-letter/{type}/{id}', [EmployeeController::class, 'hrLetter'])->name('employees.hr-letter');
    Route::get('employees-letter-pdf/{type}/{id}', [EmployeeController::class, 'hrLetterPdf'])->name('employees.hr-letter.pdf');
    Route::get('employees-letter-email/{type}/{id}', [EmployeeController::class, 'hrLetterEmail'])->name('employees.hr-letter.email');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientController::class)->names('clients');
    Route::put('client-approve/{id}', [ClientController::class, 'approve'])->name('client.approve');
    Route::get('client-welcome-letter/{id}', [ClientController::class, 'welcomeLetter'])->name('clients.welcomeLetter');
    Route::resource('client-families', ClientFamilyController::class);
    Route::get('client-families-create-from-existing', [ClientFamilyController::class, 'createFromExistingClient'])->name('client-families.create.existing');
    Route::post('client-families.store-from-existing', [ClientFamilyController::class, 'storeFromExistingClient'])->name('client-families.store.existing');
    Route::resource('client-banks', ClientBankController::class);
    Route::get('/birthday-client', [ClientBDayController::class, 'index'])
        ->name('birthday-client');
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
    Route::resource('scheme', SchemeController::class)->names('scheme');
    Route::resource('els', InvestmentController::class)->names('els');

    Route::get('els-renew', [InvestmentController::class, 'renew'])->name("renew");
    Route::get('els-claim', [InvestmentController::class, 'claim'])->name("claim");
    Route::get('els-merge', [InvestmentController::class, 'merge'])->name("merge");
    Route::get('els-maturity', [InvestmentController::class, 'maturity'])->name("maturity");
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');
require __DIR__ . '/settings.php';
