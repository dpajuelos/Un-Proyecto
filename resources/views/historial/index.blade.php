@extends('layouts.app')

@section('content')
<h2>Historial de Consultas</h2>
<ul>
    @foreach($historial as $item)
        <li>
            {{ $item->created_at }} - {{ $item->tipo_consulta }}: {{ $item->detalle }}
        </li>
    @endforeach
</ul>
@endsection