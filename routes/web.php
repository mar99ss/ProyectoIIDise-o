<?php

use App\Http\Controllers\JerarquiaController;
use App\Http\Controllers\MiembrosController;
use App\Models\Miembro;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome/welcome'); })->name('welcome');

Route::match(['put', 'patch'], '/admin/{movimiento}', [JerarquiaController::class, 'edit'])->name('admin.edit');

Route::get('/miembros', [MiembrosController::class, 'index'])->name('miembros.index')->middleware('movimiento');
Route::post('/miembros', [MiembrosController::class, 'create'])->name('miembros.create')->middleware('movimiento');
Route::match(['put', 'patch'], '/miembros', [MiembrosController::class, 'edit'])->name('miembros.edit')->middleware('movimiento');

Route::get('/movimiento/{movimiento?}', [JerarquiaController::class, 'adminIndex'])->name('admin')->middleware('movimiento');
Route::delete('/miembros/{miembro}', [MiembrosController::class, 'delete'])->name('miembros.destroy')->middleware('movimiento');


Route::post('/movimiento', [JerarquiaController::class, 'crearMovimiento'])->name('movimiento.create');

Route::get('/jerarquia', [JerarquiaController::class, 'index'])->name('jerarquia.index')->middleware('movimiento');
Route::put('/jerarquia/', [JerarquiaController::class, 'crearGrupo'])->name('jerarquia.crearGrupo')->middleware('movimiento');
Route::put('/jerarquia/{nivelJerarquico}', [JerarquiaController::class, 'crearNivelPadre'])->name('jerarquia.crearNivelJerarquico')->middleware('movimiento');
Route::delete('/jerarquia/{nivelJerarquico}', [JerarquiaController::class, 'delete'])->name('jerarquia.destroy')->middleware('movimiento');
Route::get('/jerarquia/{nivelJerarquico}/miembros', [JerarquiaController::class, 'verMiembros'])->name('jerarquia.miembros')->middleware('movimiento');
Route::get('/jerarquia/{nivelJerarquico}/filtroMiembros', [JerarquiaController::class, 'verMiembrosFiltro'])->name('jerarquia.miembrosFiltro')->middleware('movimiento');
// Route::get('/jerarquia', [JerarquiController:: class, ''])->name('jerarquia.editMiembro');

Route::get('/movimientos', function () { return view('admin.movimientos-catalog', ['movimientos' => Movimiento::all()]); })->name('movimientos.index');

//Route::match('/miembros', [MiembrosController::class, 'update'])->name('');

Route::get('/pruebaRoles', function () {
    return session('movimiento')->gestorJerarquia()->obtenerMiembros(54);
});

Route::get('/pruebaJerarquia', function () {
    session('movimiento')->gestorJerarquia()->obtenerMiembros(54);
});

Route::get('/pruebaNoAsignados', function () {
    $miembros = session('movimiento')->gestorJerarquia()->obtenerMiembros(58);
    return session('movimiento')->gestorJerarquia()->obtenerMiembrosNoAsignados($miembros);
});

Route::get('/rolesMiembros/{miembro}', [MiembrosController::class,'obtenerRolesMiembro'])->name('miembros.roles');

Route::get('/cambioJerarquico/{nivelJerarquico}/', [JerarquiaController::class, 'obtenerJerarquiaMismoNivel'])->middleware('movimiento');
Route::put('/cambioJerarquico', [JerarquiaController::class, 'cambiarDeNivel'])->middleware('movimiento')->name('miembros.cambiarNivel');


Route::post('/asignarRol', [MiembrosController::class, 'asignarRol'])->name('miembros.asignarRol');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/jerarquia/{nivelJerarquico}/miembros', [JerarquiaController::class, 'verMiembros'])->name('jerarquia.miembros')->middleware('movimiento');

 