<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Masters\BranchController;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\HeadOfficeController;
use App\Http\Controllers\Masters\DesignationController;
use App\Http\Controllers\Masters\SubDepartmentController;
use App\Http\Controllers\googleDrive\GoogleDriveController;
use App\Http\Controllers\Masters\SubDesignationController;
use App\Http\Controllers\Settings\UserManagementController;
use App\Http\Controllers\Settings\RolePermissionViewController;

// MERGED
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth', 'verified'])->prefix('master')->name('master.')->group(function () {
    Route::resource('companies', CompanyController::class);
    // ->except(['destroy'])->middleware('permission:companies.view,companies.create,companies.edit');
    Route::delete('companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('permission:companies.delete');
    Route::resource('head-offices', HeadOfficeController::class);
    // ->except(['destroy'])->middleware('permission:head-offices.view,head-offices.index, head-offices.create,head-offices.edit');
    Route::delete('head-offices/{head_office}', [HeadOfficeController::class, 'destroy'])->name('head-offices.destroy')->middleware('permission:head-offices.delete');
    Route::resource('branches', BranchController::class)->except(['destroy'])->middleware('permission:branches.view,branches.create,branches.edit');
    Route::delete('branches/{branch}', [BranchController::class, 'destroy'])->name('branches.destroy')->middleware('permission:branches.delete');
    Route::resource('departments', DepartmentController::class)->except(['destroy'])->middleware('permission:departments.view,departments.create,departments.edit');
    Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy')->middleware('permission:departments.delete');
    Route::resource('sub-departments', SubDepartmentController::class)->except(['destroy'])->middleware('permission:departments.view,departments.create,departments.edit');
    Route::delete('sub-departments/{sub_department}', [SubDepartmentController::class, 'destroy'])->name('sub-departments.destroy')->middleware('permission:departments.delete');
    Route::resource('designations', DesignationController::class)->except(['destroy'])->middleware('permission:designations.view,designations.create,designations.edit');
    Route::delete('designations/{designation}', [DesignationController::class, 'destroy'])->name('designations.destroy')->middleware('permission:designations.delete');
    Route::resource('sub-designations', SubDesignationController::class)->except(['destroy'])->middleware('permission:designations.view,designations.create,designations.edit');
    Route::delete('sub-designations/{sub_designation}', [SubDesignationController::class, 'destroy'])->name('sub-designations.destroy')->middleware('permission:designations.delete');
    Route::resource('employees', EmployeeController::class)->except(['destroy'])->middleware('permission:employees.view,employees.create,employees.edit');
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy')->middleware('permission:employees.delete');
    Route::get('employees-letter/{type}/{id}', [EmployeeController::class, 'hrLetter'])->name('employees.hr-letter')->middleware('permission:employees.view');
    Route::get('employees-letter-pdf/{type}/{id}', [EmployeeController::class, 'hrLetterPdf'])->name('employees.hr-letter.pdf')->middleware('permission:employees.view');
    Route::get('employees-letter-email/{type}/{id}', [EmployeeController::class, 'hrLetterEmail'])->name('employees.hr-letter.email')->middleware('permission:employees.view');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientController::class)->names('clients')->except(['destroy'])->middleware('permission:clients.view,clients.create,clients.edit');
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy')->middleware('permission:clients.delete');
    Route::put('client-approve/{id}', [ClientController::class, 'approve'])->name('client.approve')->middleware('permission:clients.approve');
    Route::get('client/{id}/kyc-pdf', [ClientController::class, 'downloadKycPdf'])->name('client.kyc.pdf')->middleware('permission:clients.view');
    Route::get('client-form-download', [ClientController::class, 'kycBalnkForm'])->name('client.form.download')->middleware('permission:clients.view');

    Route::resource('client-families', ClientFamilyController::class)->except(['destroy'])->middleware('permission:client-families.view,client-families.create,client-families.edit');
    Route::delete('client-families/{client_family}', [ClientFamilyController::class, 'destroy'])->name('client-families.destroy')->middleware('permission:client-families.delete');
    Route::get('client-families-create-from-existing', [ClientFamilyController::class, 'createFromExistingClient'])->name('client-families.create.existing')->middleware('permission:client-families.create');
    Route::post('client-families.store-from-existing', [ClientFamilyController::class, 'storeFromExistingClient'])->name('client-families.store.existing')->middleware('permission:client-families.create');
    Route::resource('client-banks', ClientBankController::class)->except(['destroy'])->middleware('permission:client-banks.view,client-banks.create,client-banks.edit');
    Route::delete('client-banks/{client_bank}', [ClientBankController::class, 'destroy'])->name('client-banks.destroy')->middleware('permission:client-banks.delete');
    Route::get('/birthday-client', [ClientBDayController::class, 'index'])
        ->name('birthday-client')->middleware('permission:clients.view');
    Route::post('/send-birthday-email', [ClientBDayController::class, 'sendBirthdayEmail'])
        ->name('send-birthday-email')->middleware('permission:clients.view');
    Route::post('/send-festival-mail', [ClientController::class, 'sendFestivalMail'])
        ->name('send.festival.mail')->middleware('permission:clients.view');
    Route::get('client-welcomeLetter/{id}', [ClientController::class, 'welcomeLetter'])
        ->name('client.welcomeLetter')->middleware('permission:clients.view');
    Route::get('client-onboarding', [PreClientController::class, 'index'])->name('preclients.index')->middleware('permission:preclients.view');
    route::get('/gd', [GoogleDriveController::class, 'index'])->name('gogle-drive');
    route::post('/gdrive-upload', [GoogleDriveController::class, 'googleUploadFile'])->name('google-drive-upload');
});


Route::middleware(['auth', 'verified'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::resource('vendors', VendorsController::class)->except(['destroy'])->middleware('permission:vendors.view,vendors.create,vendors.edit');
    Route::delete('vendors/{vendor}', [VendorsController::class, 'destroy'])->name('vendors.destroy')->middleware('permission:vendors.delete');
    Route::resource('purchases', PurchaseController::class)->except(['destroy'])->middleware('permission:purchases.view,purchases.create,purchases.edit');
    Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy')->middleware('permission:purchases.delete');
    Route::resource('sales', SaleController::class)->except(['destroy'])->middleware('permission:sales.view,sales.create,sales.edit');
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy')->middleware('permission:sales.delete');
    Route::resource('purchase-orders', PurchaseOrderController::class)->except(['destroy'])->middleware('permission:purchases.view,purchases.create,purchases.edit');
    Route::delete('purchase-orders/{purchase_order}', [PurchaseOrderController::class, 'destroy'])->name('purchase-orders.destroy')->middleware('permission:purchases.delete');
    Route::resource('expenses', ExpensesController::class)->except(['destroy'])->middleware('permission:expenses.view,expenses.create,expenses.edit');
    Route::delete('expenses/{expense}', [ExpensesController::class, 'destroy'])->name('expenses.destroy')->middleware('permission:expenses.delete');
    Route::resource('ledger', LedgerController::class)->middleware('permission:ledger.view');
});

Route::middleware(['auth', 'verified'])->prefix('investment')->name('investment.')->group(function () {
    Route::resource('scheme', SchemeController::class)->names('scheme')->except(['destroy'])->middleware('permission:schemes.view,schemes.create,schemes.edit');
    Route::delete('scheme/{scheme}', [SchemeController::class, 'destroy'])->name('scheme.destroy')->middleware('permission:schemes.delete');
    Route::put('scheme-approve/{id}', [SchemeController::class, 'approve'])->name('scheme.approve')->middleware('permission:schemes.approve');
    Route::put('investment-approve/{id}', [InvestmentController::class, 'approve'])->name('approve')->middleware('permission:investments.approve');
    Route::put('investment-approve-payouts/{id}', [InvestmentController::class, 'approvePayouts'])->name('approve.payouts')->middleware('permission:investment-si.approve');

    Route::resource('els', InvestmentController::class)->names('els')->except(['destroy'])->middleware('permission:investments.view,investments.create,investments.edit');
    Route::delete('els/{el}', [InvestmentController::class, 'destroy'])->name('els.destroy')->middleware('permission:investments.delete');
    Route::resource('si', InvestmentSiController::class)->names('si')->except(['destroy'])->middleware('permission:investment-si.view,investment-si.create,investment-si.edit');
    Route::delete('si/{si}', [InvestmentSiController::class, 'destroy'])->name('si.destroy')->middleware('permission:investment-si.delete');
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

    Route::put('/investment-payout-mark-paid', [InvestmentController::class, 'markPaid'])->name('payout.mark-paid')->middleware('permission:investments.mark-paid');
    Route::post('/investment-payout-schedule-add', [InvestmentController::class, 'addPayoutSchedule'])->name('payout.schedule.add')->middleware('permission:investments.edit');
    Route::post('/investment-payment-schedule-import', [InvestmentController::class, 'importPaymentSchedule'])->name('payment.schedule.import')->middleware('permission:investments.edit');
    Route::get('/investment-payment-schedule-sample/{investment}', [InvestmentController::class, 'downloadPaymentScheduleSample'])->name('payment.schedule.sample');
    Route::get('/investment-closing-letter-show', [InvestmentController::class, 'closingLetterShow'])->name('closing.letter.show');

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
