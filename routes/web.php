<?php

use App\Http\Controllers\clienteController;
use App\Http\Controllers\empleadoController;
use App\Http\Controllers\cuentaController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\permisoController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\tarjetaController;
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
    'empleados' => empleadoController::class,
    'roles' => roleController::class,
    'users' => userController::class,
    'cuentas' => cuentaController::class,
    'tarjetas' => tarjetaController::class,
    'permisos' => permisoController::class
]);
Route::put('/permisos', [PermisoController::class, 'update'])->name('permisos.update');
Route::delete('/permisos/{id}', [PermisoController::class, 'destroy'])->name('permisos.destroy');



Route::get('/login',[loginController::class,'index'])->name('login');
Route::post('/login',[loginController::class,'login']);
Route::get('/logout',[logoutController::class,'logout'])->name('logout');


Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
