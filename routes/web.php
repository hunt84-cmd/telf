<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmisoraController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\LineaController;

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

// Ruta principal - Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para Emisoras
Route::resource('emisoras', EmisoraController::class);
Route::get('emisoras/{emisora}/personas', [EmisoraController::class, 'show'])->name('emisoras.personas');

// Rutas para Personas
Route::resource('personas', PersonaController::class);
Route::get('personas/emisora/{emisora}', [PersonaController::class, 'getByEmisora'])->name('personas.by-emisora');

// Rutas para Paquetes
Route::resource('paquetes', PaqueteController::class);
Route::get('paquetes/disponibles', [PaqueteController::class, 'getDisponibles'])->name('paquetes.disponibles');

// Rutas para Teléfonos
Route::resource('telefonos', TelefonoController::class);
Route::get('telefonos/almacen', [TelefonoController::class, 'almacen'])->name('telefonos.almacen');
Route::get('telefonos/asignados', [TelefonoController::class, 'asignados'])->name('telefonos.asignados');
Route::get('telefonos/{telefono}/asignar', [TelefonoController::class, 'asignar'])->name('telefonos.asignar');
Route::post('telefonos/{telefono}/asignar', [TelefonoController::class, 'asignarPersona'])->name('telefonos.asignar-persona');
Route::post('telefonos/{telefono}/devolver', [TelefonoController::class, 'devolverAlmacen'])->name('telefonos.devolver-almacen');

// Rutas para Líneas
Route::resource('lineas', LineaController::class);
Route::get('lineas/almacen', [LineaController::class, 'almacen'])->name('lineas.almacen');
Route::get('lineas/asignadas', [LineaController::class, 'asignadas'])->name('lineas.asignadas');
Route::get('lineas/{linea}/asignar', [LineaController::class, 'asignar'])->name('lineas.asignar');
Route::post('lineas/{linea}/asignar', [LineaController::class, 'asignarPersona'])->name('lineas.asignar-persona');
Route::post('lineas/{linea}/devolver', [LineaController::class, 'devolverAlmacen'])->name('lineas.devolver-almacen');
Route::post('lineas/{linea}/paquete', [LineaController::class, 'asignarPaquete'])->name('lineas.asignar-paquete');
Route::delete('lineas/{linea}/paquete', [LineaController::class, 'quitarPaquete'])->name('lineas.quitar-paquete');

// Rutas para API del Dashboard
Route::prefix('api/dashboard')->name('api.dashboard.')->group(function () {
    Route::get('stats', [DashboardController::class, 'getStats'])->name('stats');
    Route::get('stats/emisoras', [DashboardController::class, 'getStatsByEmisora'])->name('stats.emisoras');
    Route::get('inventario', [DashboardController::class, 'getInventarioAlmacen'])->name('inventario');
    Route::get('asignaciones', [DashboardController::class, 'getAsignacionesActivas'])->name('asignaciones');
});

// Rutas para API de cada recurso
Route::prefix('api')->name('api.')->group(function () {
    Route::get('emisoras', [EmisoraController::class, 'apiIndex'])->name('emisoras.index');
    Route::get('personas', [PersonaController::class, 'apiIndex'])->name('personas.index');
    Route::get('paquetes', [PaqueteController::class, 'apiIndex'])->name('paquetes.index');
    Route::get('telefonos', [TelefonoController::class, 'apiIndex'])->name('telefonos.index');
    Route::get('lineas', [LineaController::class, 'apiIndex'])->name('lineas.index');
    
    // Rutas adicionales para API
    Route::get('telefonos/disponibles', [TelefonoController::class, 'getDisponibles'])->name('telefonos.disponibles');
    Route::get('lineas/disponibles', [LineaController::class, 'getDisponibles'])->name('lineas.disponibles');
    Route::get('paquetes/disponibles', [PaqueteController::class, 'getDisponibles'])->name('paquetes.disponibles');
});
