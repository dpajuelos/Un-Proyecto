@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Cita</h1>
    
    <form action="{{ route('citas.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_rep" class="form-label">Representante</label>
                    <select class="form-select" id="id_rep" name="id_rep" required>
                        <option value="">Seleccione un representante</option>
                        @foreach($representantes as $rep)
                            <option value="{{ $rep->id }}">{{ $rep->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                
                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" class="form-control" id="hora" name="hora" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_rep_sus" class="form-label">Representante Sustituto (opcional)</label>
                    <select class="form-select" id="id_rep_sus" name="id_rep_sus">
                        <option value="">Ninguno</option>
                        @foreach($representantes as $rep)
                            <option value="{{ $rep->id }}">{{ $rep->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Cita</button>
        <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection