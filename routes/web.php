<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\OnlineStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/dbcont', function () {
    return view('dbcon');
});

// the login routes

Route::get('/login', [loginController::class, 'index'])->name('login');

Route::get('/newlogin', [loginController::class, 'create'])->name('register');

Route::post('/newlogin', [loginController::class, 'store'])->name('register.store');

Route::post('/login', [loginController::class, 'login'])->name('login.submit');

Route::post('/logout', [loginController::class, 'logout'])->name('logout');


// Password reset (forgot password) routes
use App\Http\Controllers\ForgotPasswordController;

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

 Route::middleware('auth')->prefix('owner')->name('owner.')->group(function () {
    Route::resource('products', ProductController::class)->except('show');
});

// the online store routes
Route::get('/store', [OnlineStoreController::class, 'index'])->name('onlineStore');

Route::get('/woman', [OnlineStoreController::class, 'woman'])->name('woman');

Route::get('/man', [OnlineStoreController::class, 'man'])->name('man');

Route::get('/Kids', [OnlineStoreController::class, 'Kids'])->name('Kids');

Route::get('/online/create', [OnlineStoreController::class, 'admain'])->name('admain');

Route::post('/online/create', [OnlineStoreController::class, 'store'])->name('admain.store');
