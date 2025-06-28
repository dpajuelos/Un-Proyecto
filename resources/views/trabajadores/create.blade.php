@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3>Nuevo Trabajador</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_usuario" class="form-label">ID Usuario</label>
                    <input type="number" name="id_usuario" id="id_usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_cargo" class="form-label">ID Cargo</label>
                    <input type="number" name="id_cargo" id="id_cargo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_espe" class="form-label">ID Especialización</label>
                    <input type="number" name="id_espe" id="id_espe" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
</div>
@endsection