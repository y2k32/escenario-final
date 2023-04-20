<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFAController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Aqui se pueden agregar por separado las rutas que no seran consultadas desde un navegador web
// O que su proposito original no es ese, por ej aqui va la ruta a la que se conecta al cel
Route::post('/check/app/code', [TwoFAController::class, 'ckeckCodeApp']);


// Muestra el QR que contiene una ruta firmada
Route::post('/verifying/qrcode', [TwoFAController::class, 'verifying_qr'])->name('verifying_qr');
// Ayuda a generar la ruta firmada para qr movil
Route::get('/check/app/qrcode', [TwoFAController::class, 'ckeckCodeApp2'])->middleware('signed')->name('get_qrcode');

//Route::post('/verificate/qrcode', [TwoFAController::class, 'verificateQr'])->name('verificateQr');