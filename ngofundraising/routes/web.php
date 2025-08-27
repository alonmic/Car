<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinLoginController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PaymentController;

Route::get('/', fn()=> redirect()->route('otp.form'));

Route::prefix('auth')->group(function(){
    Route::get('/login', [PinLoginController::class,'showForm'])->name('otp.form');
    Route::post('/send-pin', [PinLoginController::class,'sendPin'])->name('otp.send');
    Route::post('/verify-pin', [PinLoginController::class,'verify'])->name('otp.verify');
    Route::post('/logout', [PinLoginController::class,'logout'])->name('logout');
});

Route::middleware('auth')->group(function(){
    // User routes
    Route::get('/dashboard',[UserDashboardController::class,'index'])->name('user.dashboard');
    Route::get('/donate',[DonationController::class,'create'])->name('donate.create');
    Route::post('/donate',[DonationController::class,'store'])->name('donate.store');
    Route::post('/donation/{id}/upload-proof',[PaymentController::class,'upload'])->name('donation.upload');

    // Admin routes
    Route::middleware('can:isAdmin')->group(function(){
        Route::get('/admin/dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
        Route::post('/admin/proof/{id}/verify',[AdminDashboardController::class,'verifyProof'])->name('admin.proof.verify');
    });
});