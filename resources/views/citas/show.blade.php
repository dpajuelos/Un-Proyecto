{{-- filepath: c:\xampp\htdocs\citasProyecto\citasProyecto\resources\views\citas\show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Detalle de Cita</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $cita->id_cita }}</p>
            <p><strong>ID Representante:</strong> {{ $cita->id_rep }}</p>
            <p><strong>ID Sustituto:</strong> {{ $cita->id_rep_sus }}</p>
            <p><strong>Fecha:</strong> {{ $cita->fecha }}</p>
            <p><strong>Hora:</strong> {{ $cita->hora }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($cita->estado) }}</p>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection