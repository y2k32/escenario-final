<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\CodigoController;
use Illuminate\Support\Facades\Route;


/** Aqui estan las rutas referentes al Auth que laravel breeze nos ofrece */



Route::middleware('guest')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::get('all/products', [ProductoController::class, 'allproducts'])
        ->name('all.products');
    Route::get('products', [ProductoController::class, 'index'])
        ->name('products');
    Route::post('create/product', [ProductoController::class, 'store'])
        ->name('register.product');
    Route::get('show/product/{id}', [ProductoController::class, 'viewdata'])
        ->name('show.product');
    Route::post('show/product/{id}', [ProductoController::class, 'viewdata'])
        ->name('show.product');
    Route::get('show/del/product/{id}', [ProductoController::class, 'viewdata2'])
        ->name('showdel.product');
    Route::post('show/del/product/{id}', [ProductoController::class, 'viewdata2'])
        ->name('showdel.product');
    Route::post('update/product', [ProductoController::class, 'edit'])
        ->name('update.product');
    Route::post('delete/product', [ProductoController::class, 'delete'])
        ->name('del.product');


    Route::get('all/entradas', [EntradaController::class, 'allentradas'])
        ->name('all.entradas');
    Route::get('entradas', [EntradaController::class, 'index'])
        ->name('entradas');
    Route::post('create/entrada', [EntradaController::class, 'store'])
        ->name('register.entrada');
    Route::get('show/entrada/{id}', [EntradaController::class, 'viewdata'])
        ->name('show.entrada');
    Route::post('show/entrada/{id}', [EntradaController::class, 'viewdata'])
        ->name('show.entrada');
    Route::post('edit/entrada', [EntradaController::class, 'edit'])
        ->name('update.entrada');
    Route::post('delete/entrada', [EntradaController::class, 'delete'])
        ->name('del.entrada');


    Route::get('all/salidas', [SalidaController::class, 'allsalidas'])
        ->name('all.salidas');
    Route::get('salidas', [SalidaController::class, 'index'])
        ->name('salidas');
    Route::post('create/salida', [SalidaController::class, 'store'])
        ->name('register.salida');
    Route::get('show/salida/{id}', [SalidaController::class, 'viewdata'])
        ->name('show.salida');
    Route::post('show/salida/{id}', [SalidaController::class, 'viewdata'])
        ->name('show.salida');
    Route::post('edit/salida', [SalidaController::class, 'edit'])
        ->name('update.salida');
    Route::post('delete/salida', [SalidaController::class, 'delete'])
        ->name('del.salida');


    Route::get('show/user/{id}', [RegisteredUserController::class, 'viewdata'])
        ->name('show.user');
    Route::post('show/user/{id}', [RegisteredUserController::class, 'viewdata'])
        ->name('show.user');
    Route::post('edit/user', [RegisteredUserController::class, 'edit'])
        ->name('update.user');
    Route::get('all/users', [RegisteredUserController::class, 'allusers'])
        ->name('all.users');
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rutas para generar codigo de autorizacion
    Route::get('/genarate/code', [CodigoController::class, 'generate'])->name('gen_code');
    Route::get('/code/autorization', [CodigoController::class, 'show'])->middleware('signed')->name('show_code_v');

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
