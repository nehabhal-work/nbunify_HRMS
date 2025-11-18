<?php

use App\Http\Controllers\Api\FileUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BankController;

Route::post('/validate-ifsc', [BankController::class, 'validateIfsc'])->name('validate-ifsc');
Route::post('/upload-temp-file', [FileUploadController::class, 'uploadToTempStorage'])->name('upload-temp-file');
