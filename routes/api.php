<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BankController;

Route::post('/validate-ifsc', [BankController::class, 'validateIfsc'])->name('validate-ifsc');
