<?php

use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HistorialConsultaController;
use App\Http\Controllers\MineraController;
use App\Http\Controllers\TrabajadorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('/logout', function () {
        session()->forget('usuario');
        return redirect('/')->with('success', 'Sesión cerrada exitosamente.');
    });
});

// Route::resource('citas', CitaController::class);
// Route::put('citas/{cita}/reprogramar', [CitaController::class, 'reprogramar'])->name('citas.reprogramar');

// Rutas para el manejo de citas
Route::get('/organigrama/pdf', [App\Http\Controllers\OrganigramaController::class, 'pdf'])->name('organigrama.pdf');

Route::get('/institucional/misionvision', function () {
    return view('institucional.misionvision');
})->name('institucional.misionvision');
Route::get('/institucional/historia', function () {
    return view('historia');
})->name('institucional.historia');

Route::prefix('citas')->name('citas.')->group(function () {
    Route::get('/', [CitaController::class, 'index'])->name('index');
    Route::get('/crear', [CitaController::class, 'create'])->name('create');
    Route::post('/', [CitaController::class, 'store'])->name('store');
    Route::get('/{id}/reprogramar', [CitaController::class, 'reprogramar'])->name('reprogramar');
    Route::put('/{id}/reprogramar', [CitaController::class, 'updateReprogramacion'])->name('update-reprogramacion');
    Route::patch('/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('cambiar-estado');
    Route::delete('/{id}', [CitaController::class, 'destroy'])->name('destroy');
    Route::get('/representante/{id}', [CitaController::class, 'getRepresentanteData'])->name('representante-data');
    Route::get('/{id}', [CitaController::class, 'show'])->name('show');
});
Route::resource('mineras', 'MineraController');
Route::resource('mineras', MineraController::class);
// Route::get('/personas', function () {
//  return view('personas.indexa');
// });

// Route::get('/personas/createa', function () {
//  return view('personas.createa');
// });
Route::resource('personas', App\Http\Controllers\PersonasController::class)->names([
    'index' => 'personas.index',
    'create' => 'personas.create',
    'store' => 'personas.store',
    'show' => 'personas.show',
    'edit' => 'personas.edit',
    'update' => 'personas.update',
    'destroy' => 'personas.destroy',
]);
Route::resource('mineras', App\Http\Controllers\MineraController::class)->names([
    'index' => 'mineras.index',
    'create' => 'mineras.create',
    'store' => 'mineras.store',
    'show' => 'mineras.show',
    'edit' => 'mineras.edit',
    'update' => 'mineras.update',
    'destroy' => 'mineras.destroy',
]);
Route::put('/mineras/{id}', [MineraController::class, 'update'])->name('mineras.update');
Route::resource('citas', App\Http\Controllers\CitaController::class)->names([
    'index' => 'citas.index',
    'create' => 'citas.createa',
    'store' => 'citas.store',
    'show' => 'citas.show',
    'edit' => 'citas.edit',
    'update' => 'citas.update',
    'destroy' => 'citas.destroy',
]);
Route::get('/organigrama', function () {
    return view('Organigrama');
})->name('organigrama');
Route::get('/trabajadores', [TrabajadorController::class, 'index'])->name('trabajadores.index');
Route::get('/trabajadores/{id_trabajador}', [TrabajadorController::class, 'show'])->name('trabajadores.show');
Route::resource('trabajadores', TrabajadorController::class);
Route::get('/informes', function () {
    return view('informes.index');
})->name('informes.index');
Route::get('/portal-cliente', function () {
    return view('portal.cliente');
})->name('portal.cliente');

Route::get('/historial', [App\Http\Controllers\HistorialConsultaController::class, 'index'])->name('historial.index');
Route::get('/historial/estadisticas', [App\Http\Controllers\HistorialConsultaController::class, 'estadisticas'])->name('historial.estadisticas');
Route::get('/historial/{id}', [App\Http\Controllers\HistorialConsultaController::class, 'show'])->name('historial.show');
Route::delete('/historial/{id}', [App\Http\Controllers\HistorialConsultaController::class, 'destroy'])->name('historial.destroy');
Route::post('/historial/limpiar', [App\Http\Controllers\HistorialConsultaController::class, 'limpiar'])->name('historial.limpiar');
