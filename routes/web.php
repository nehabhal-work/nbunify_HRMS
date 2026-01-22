<?php

use App\Http\Controllers\Accounts\ExpensesController;
use App\Http\Controllers\Accounts\LedgerController;
use App\Http\Controllers\Accounts\PurchaseOrderController;
use App\Http\Controllers\Accounts\PurchaseController;
use App\Http\Controllers\Accounts\SaleController;
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
use App\Http\Controllers\PreClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\Masters\HeadOfficeController;
use App\Http\Controllers\Masters\BranchController;
use App\Http\Controllers\Investment\InvestmentSiController;

// MERGED
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('client-onboarding/create', [PreClientController::class, 'create'])->name('preclients.create');
Route::post('client-onboarding', [PreClientController::class, 'store'])->name('preclients.store');
Route::get('client-onboarding/{id}/view', [PreClientController::class, 'show'])->name('preclients.show');

Route::middleware(['auth', 'verified'])->prefix('master')->name('master.')->group(function () {
    Route::resource('companies', CompanyController::class)->middleware('permission:companies.view,companies.create,companies.edit,companies.delete');
    Route::resource('head-offices', HeadOfficeController::class)->middleware('permission:head-offices.view,head-offices.create,head-offices.edit,head-offices.delete');
    Route::resource('branches', BranchController::class)->middleware('permission:branches.view,branches.create,branches.edit,branches.delete');
    Route::resource('departments', DepartmentController::class)->middleware('permission:departments.view,departments.create,departments.edit,departments.delete');
    Route::resource('sub-departments', SubDepartmentController::class)->middleware('permission:departments.view,departments.create,departments.edit,departments.delete');
    Route::resource('designations', DesignationController::class)->middleware('permission:designations.view,designations.create,designations.edit,designations.delete');
    Route::resource('sub-designations', SubDesignationController::class)->middleware('permission:designations.view,designations.create,designations.edit,designations.delete');
    Route::resource('employees', EmployeeController::class)->middleware('permission:employees.view,employees.create,employees.edit,employees.delete');
    Route::get('employees-letter/{type}/{id}', [EmployeeController::class, 'hrLetter'])->name('employees.hr-letter')->middleware('permission:employees.view');
    Route::get('employees-letter-pdf/{type}/{id}', [EmployeeController::class, 'hrLetterPdf'])->name('employees.hr-letter.pdf')->middleware('permission:employees.view');
    Route::get('employees-letter-email/{type}/{id}', [EmployeeController::class, 'hrLetterEmail'])->name('employees.hr-letter.email')->middleware('permission:employees.view');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientController::class)->names('clients')->middleware('permission:clients.view,clients.create,clients.edit,clients.delete');
    Route::put('client-approve/{id}', [ClientController::class, 'approve'])->name('client.approve')->middleware('permission:clients.approve');
    Route::get('client/{id}/kyc-pdf', [ClientController::class, 'downloadKycPdf'])->name('client.kyc.pdf')->middleware('permission:clients.view');
    Route::get('client-form-download', [ClientController::class, 'kycBalnkForm'])->name('client.form.download')->middleware('permission:clients.view');

    Route::resource('client-families', ClientFamilyController::class)->middleware('permission:client-families.view,client-families.create,client-families.edit,client-families.delete');
    Route::get('client-families-create-from-existing', [ClientFamilyController::class, 'createFromExistingClient'])->name('client-families.create.existing')->middleware('permission:client-families.create');
    Route::post('client-families.store-from-existing', [ClientFamilyController::class, 'storeFromExistingClient'])->name('client-families.store.existing')->middleware('permission:client-families.create');
    Route::resource('client-banks', ClientBankController::class)->middleware('permission:client-banks.view,client-banks.create,client-banks.edit,client-banks.delete');
    Route::get('/birthday-client', [ClientBDayController::class, 'index'])
        ->name('birthday-client')->middleware('permission:clients.view');
    Route::post('/send-birthday-email', [ClientBDayController::class, 'sendBirthdayEmail'])
        ->name('send-birthday-email')->middleware('permission:clients.view');
    Route::post('/send-festival-mail', [ClientController::class, 'sendFestivalMail'])
        ->name('send.festival.mail')->middleware('permission:clients.view');
    Route::get('client-welcomeLetter/{id}', [ClientController::class, 'welcomeLetter'])
        ->name('client.welcomeLetter')->middleware('permission:clients.view');
    Route::get('client-onboarding', [PreClientController::class, 'index'])->name('preclients.index')->middleware('permission:preclients.view');
});

Route::middleware(['auth', 'verified'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::resource('vendors', VendorsController::class)->middleware('permission:vendors.view,vendors.create,vendors.edit,vendors.delete');
    Route::resource('purchases', PurchaseController::class)->middleware('permission:purchases.view,purchases.create,purchases.edit,purchases.delete');
    Route::resource('sales', SaleController::class)->middleware('permission:sales.view,sales.create,sales.edit,sales.delete');
    Route::resource('purchase-orders', PurchaseOrderController::class)->middleware('permission:purchases.view,purchases.create,purchases.edit,purchases.delete');
    Route::resource('expenses', ExpensesController::class)->middleware('permission:expenses.view,expenses.create,expenses.edit,expenses.delete');
    Route::resource('ledger', LedgerController::class)->middleware('permission:ledger.view');
});

Route::middleware(['auth', 'verified'])->prefix('investment')->name('investment.')->group(function () {
    Route::resource('scheme', SchemeController::class)->names('scheme')->middleware('permission:schemes.view,schemes.create,schemes.edit,schemes.delete');
    Route::put('scheme-approve/{id}', [SchemeController::class, 'approve'])->name('scheme.approve')->middleware('permission:schemes.approve');
    Route::put('investment-approve/{id}', [InvestmentController::class, 'approve'])->name('approve')->middleware('permission:investments.approve');

    Route::resource('els', InvestmentController::class)->names('els')->middleware('permission:investments.view,investments.create,investments.edit,investments.delete');
    Route::resource('si', InvestmentSiController::class)->names('si')->middleware('permission:investment-si.view,investment-si.create,investment-si.edit,investment-si.delete');
    Route::put('si-approve/{id}', [InvestmentSiController::class, 'approve'])->name('si.approve')->middleware('permission:investment-si.approve');


    Route::get('els-renew', [InvestmentController::class, 'renew'])->name("renew")->middleware('permission:investments.view');
    Route::get('els-claim', [InvestmentController::class, 'claim'])->name("claim")->middleware('permission:investments.view');
    Route::get('els-merge', [InvestmentController::class, 'merge'])->name("merge")->middleware('permission:investments.view');
    Route::get('els-maturity', [InvestmentController::class, 'maturity'])->name("maturity")->middleware('permission:investments.view');
    Route::get('els-maturity-leteer', [InvestmentController::class, 'maturityLetter'])->name("maturity-letter")->middleware('permission:investments.view');
    Route::get('els-maturity-kyc', [InvestmentController::class, 'maturityKYC'])->name("maturity-kyc")->middleware('permission:investments.view');

    Route::get('els-welcome-letter/{id}', [InvestmentController::class, 'welcomeLetter'])->name('welcomeLetter')->middleware('permission:investments.view');
    Route::get('/investment/{id}/pdf', [InvestmentController::class, 'welcomeLetterDownloadPdf'])->name('welcome.pdf')->middleware('permission:investments.view');
    Route::get('/investment/{id}/email', [InvestmentController::class, 'sendEmailWithPdf'])->name('welcome.email')->middleware('permission:investments.view');

    Route::put('/investment-payout-mark-paid', [InvestmentController::class, 'markPaid'])->name('payout.mark-paid')->middleware('permission:investments.edit');

    Route::get('schemes-by-date', [InvestmentController::class, 'getSchemesByDate'])
        ->name('schemes.by.date')->middleware('permission:schemes.view');
});


Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');
require __DIR__ . '/settings.php';
