{{-- filepath: c:\xampp\htdocs\citasProyecto\citasProyecto\resources\views\citas\edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Editar Cita</h2>
    <form method="POST" action="{{ route('citas.update', $cita->id_cita) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_rep" class="form-label">ID Representante</label>
            <input type="number" class="form-control" name="id_rep" value="{{ $cita->id_rep }}" required>
        </div>
        <div class="mb-3">
            <label for="id_rep_sus" class="form-label">ID Sustituto</label>
            <input type="number" class="form-control" name="id_rep_sus" value="{{ $cita->id_rep_sus }}">
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" value="{{ $cita->fecha }}" required>
        </div>
        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control" name="hora" value="{{ $cita->hora }}" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" name="estado" required>
                <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                <option value="reprogramada" {{ $cita->estado == 'reprogramada' ? 'selected' : '' }}>Reprogramada</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection