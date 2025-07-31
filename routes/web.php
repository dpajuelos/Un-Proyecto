<?php

use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HistorialConsultaController;
use App\Http\Controllers\MineraController;
use App\Http\Controllers\TrabajadorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

// Rutas para el formulario de contacto
Route::get('/contacto', [ContactoController::class, 'create'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// APIs para búsqueda y verificación
Route::post('/api/search-minera', [ContactoController::class, 'searchMinera']);
Route::post('/api/search-persona', [ContactoController::class, 'searchPersona']);
Route::post('/api/check-cita-availability', [ContactoController::class, 'checkAvailability']);
Route::post('/api/get-available-slots', [ContactoController::class, 'getAvailableSlots']);

// Ruta para login (si la necesitas)
Route::get('/login', function () {
    return view('login');
})->name('login');

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

Route::get('/organigrama/pdf', [App\Http\Controllers\OrganigramaController::class, 'pdf'])->name('organigrama.pdf');

Route::get('/institucional/misionvision', function () {
    return view('institucional.misionvision');
})->name('institucional.misionvision');
Route::get('/institucional/historia', function () {
    return view('historia');
})->name('institucional.historia');

// Rutas de citas
Route::prefix('citas')->name('citas.')->group(function () {
    Route::get('/', [CitaController::class, 'index'])->name('index');
    Route::get('/crear', [CitaController::class, 'create'])->name('create');
    Route::post('/', [CitaController::class, 'store'])->name('store');
    Route::get('/{id}/editar', [CitaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CitaController::class, 'update'])->name('update');
    Route::get('/{id}/reprogramar', [CitaController::class, 'reprogramar'])->name('reprogramar');
    Route::put('/{id}/reprogramar', [CitaController::class, 'updateReprogramacion'])->name('update-reprogramacion');
    Route::patch('/{id}/estado', [CitaController::class, 'cambiarEstado'])->name('cambiar-estado');
    Route::delete('/{id}', [CitaController::class, 'destroy'])->name('destroy');
    Route::get('/representante/{id}', [CitaController::class, 'getRepresentanteData'])->name('representante-data');
    Route::get('/{id}', [CitaController::class, 'show'])->name('show');
});

Route::resource('personas', App\Http\Controllers\PersonasController::class);
Route::resource('mineras', MineraController::class);

Route::resource('trabajadores', TrabajadorController::class)->names([
    'index' => 'trabajadores.index',
    'create' => 'trabajadores.create',
    'store' => 'trabajadores.store',
    'show' => 'trabajadores.show',
    'edit' => 'trabajadores.edit',
    'update' => 'trabajadores.update',
    'destroy' => 'trabajadores.destroy',
]);

Route::get('/organigrama', function () {
    return view('Organigrama');
})->name('organigrama');

Route::get('/informes', function () {
    return view('informes.index');
})->name('informes.index');
Route::get('/portal-cliente', function () {
    return view('portal.cliente');
})->name('portal.cliente');

Route::get('/historial', [App\Http\Controllers\HistorialConsultaController::class, 'index'])->name('historial.index');
Route::get('/historial/{id}', [App\Http\Controllers\HistorialConsultaController::class, 'show'])->name('historial.show');
Route::get('/historial/estadisticas', [App\Http\Controllers\HistorialConsultaController::class, 'estadisticas'])->name('historial.estadisticas');
Route::delete('/historial/{id}', [App\Http\Controllers\HistorialConsultaController::class, 'destroy'])->name('historial.destroy');
Route::post('/historial/limpiar', [App\Http\Controllers\HistorialConsultaController::class, 'limpiar'])->name('historial.limpiar');
