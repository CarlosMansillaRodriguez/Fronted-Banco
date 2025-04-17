<?php

use App\Http\Controllers\clienteController;
use App\Http\Controllers\cuentaController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('template');
}); 

Route::view('/panel','panel.index')->name('panel');
*/

Route::get('/',[homeController::class,'index'])->name('panel');

Route::resources([
    'clientes' => clienteController::class,
    'roles' => roleController::class,
    'users' => userController::class,
    'cuentas' => cuentaController::class
]);

Route::get('/login', function () {
    return view('auth.login');
});


Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
