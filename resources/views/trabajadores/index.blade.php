@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Lista de Trabajadores</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID Trabajador</th>
                        <th>DNI</th>
                        <th>ID Usuario</th>
                        <th>ID Cargo</th>
                        <th>ID Especialización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trabajadores as $trabajador)
                    <tr>
                        <td>{{ $trabajador->id_trabajador }}</td>
                        <td>{{ $trabajador->dni }}</td>
                        <td>{{ $trabajador->id_usuario }}</td>
                        <td>{{ $trabajador->id_cargo }}</td>
                        <td>{{ $trabajador->id_espe }}</td>
                        <td>
                            <a href="{{ route('trabajadores.show', $trabajador->id_trabajador) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                Ver
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay trabajadores registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ url('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
