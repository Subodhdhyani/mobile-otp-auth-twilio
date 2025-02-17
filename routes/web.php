<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/generate-otp', [OtpController::class, 'generateOtp'])->name('generate-otp');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify-otp');
Route::get('/resend-otp', [OtpController::class, 'resendOtp'])->name('resend-otp');