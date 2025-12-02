<?php

use App\Http\Controllers\Api\FileUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\GetStateCitiesController;
use App\Http\Controllers\Api\InvestmentController;

Route::post('/validate-ifsc', [BankController::class, 'validateIfsc'])->name('validate-ifsc');
Route::post('/check-client-pan-exists', [ClientController::class, 'checkPanExists'])->name('check-client-pan-exists');
Route::post('/upload-temp-file', [FileUploadController::class, 'uploadToTempStorage'])->name('upload-temp-file');
Route::get('get-cities/{country}/{state}', [GetStateCitiesController::class, 'getCitiesByState']);
Route::get('get-countries', [GetStateCitiesController::class, 'getCountries']);
Route::post('/calculate-investment-parameters', [InvestmentController::class, 'getPayoutSchedule'])->name('calculate-investment-parameters');
