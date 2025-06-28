{{-- filepath: c:\xampp\htdocs\citasProyecto\citasProyecto\resources\views\mineras\edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Editar Minera</h2>
    <form action="{{ route('mineras.update', $minera->id_minera) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre_minera" class="form-label">Nombre de la Minera</label>
            <input type="text" class="form-control" id="nombre_minera" name="nombre_minera" value="{{ old('nombre_minera', $minera->nombre_minera) }}" required>
        </div>
        <div class="mb-3">
            <label for="ruc" class="form-label">RUC</label>
            <input type="text" class="form-control" id="ruc" name="ruc" value="{{ old('ruc', $minera->ruc) }}" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $minera->direccion) }}" required>
        </div>
        <div class="mb-3">
            <label for="telefono_contacto" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto', $minera->telefono_contacto) }}" required>
        </div>
        <div class="mb-3">
            <label for="correo_contacto" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo_contacto" name="correo_contacto" value="{{ old('correo_contacto', $minera->correo_contacto) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('mineras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection