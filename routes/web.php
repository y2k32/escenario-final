<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFAController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupervisorController;
use App\Http\Middleware\HasCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('admin')->name('admin.')->group(function(){
    // los admin solo entrara por vpn
    // para desactivar una cuenta o eliminar necesitas autorizacion del administrador 
    Route::get('/dashboard',[AdminController::class, 'store'])
    ->middleware(['auth', 'verified', 'has_code'])
    ->name('dashboard');
    Route::get('/has/code', [TwoFAController::class, 'store'])->name('has_code');
    Route::get('/login',[AdminController::class, 'index'])->name('login');
    Route::post('/login',[AdminController::class, 'store'])->name('login');
    // Tambien agregare las rutas para cruds de productos, entradas y salidas

});

/*
|--------------------------------------------------------------------------
| Supervisor Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('supervisor')->group(function(){
    // supervisor puede entrar por ambas parter vpn y dominio
    // para modificar datos de las tablas le deve pedir un token del supervisos para hacer el update
    Route::get('/dashboard',[AdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'has_code'])
    ->name('supervisor.dashboard');
    Route::get('/has/code', [TwoFAController::class, 'store'])->name('supervisor.has_code');
    Route::get('/login',[AdminController::class, 'store'])->name('supervisor.login');
    // Tambien agregare las rutas para cruds de productos, entradas y salidas

});


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
    // EN el user normal ya no checare si tiene un codigo has_code
    // o no para entrar al dashboard porque no necesita mas que
    // su email y password
})->middleware(['auth', 'verified', 'has_code'])->name('dashboard');
//})->middleware(['auth', 'verified', 'has_code'])->name('dashboard');

// Cheque si el usuario tiene un codigo y si no lo crea
// ademas crea la ruta firmada y envia el email
Route::get('/has/code', [TwoFAController::class, 'store'])->name('has_code');
// Route::get('/checkcode', function(){
//     return view('codes.checkcode');
// })->name('ch_code');

// Envia la vista con el codigo desencriptado
Route::get('/code', [TwoFAController::class, 'show'])->middleware('signed')->name('show_code');

// Ruta usada para validar el codigo recivido 
Route::post('/check/code/dos', [TwoFAController::class, 'ckeckCodeWebDos'])->name('v_code2');

// Ruta usada para validar el codigo qr
Route::post('/check/code/tres', [TwoFAController::class, 'ckeckCodeWebDos'])->name('v_code2');

// Ruta usada para validar el codigo recivido 
Route::post('/check/code', [TwoFAController::class, 'ckeckCodeWeb'])->name('v_code');

//Route::get('/verificate/qrcode', [QrCodeController::class, 'qr_verified'])->name('qr_verificated'); // Esta ruta es la que valida el codigo web



// Ruta en la que el qr se da por valido y se genera la sesion
Route::get('/verificated/qrcode', [TwoFAController::class, 'verificated_qr'])->name('verificated_qr');

//Route::middleware(['auth','Has_Code'])->group(function () {
Route::middleware(['auth','has_code'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
