{{-- filepath: resources/views/trabajadores/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Detalle del Trabajador</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><strong>ID Trabajador:</strong> {{ $trabajador->id_trabajador }}</li>
                <li class="list-group-item"><strong>DNI:</strong> {{ $trabajador->dni }}</li>
                <li class="list-group-item"><strong>ID Usuario:</strong> {{ $trabajador->id_usuario }}</li>
                <li class="list-group-item"><strong>ID Cargo:</strong> {{ $trabajador->id_cargo }}</li>
                <li class="list-group-item"><strong>ID Especialización:</strong> {{ $trabajador->id_espe }}</li>
            </ul>
            <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
            <a href="{{ route('trabajadores.create') }}" class="btn btn-success mt-3 ms-2">
                <i class="fas fa-user-plus"></i> Nuevo Trabajador
            </a>
        </div>
    </div>
</div>
@endsection