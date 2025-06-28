@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-industry"></i> Gestión de Mineras</h3>
            <button class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNuevaMinera">
                <i class="fas fa-plus"></i> Nueva Minera
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <input type="text" class="form-control" id="buscarMinera" placeholder="Buscar por nombre...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tablaMineras">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mineras as $minera)
                        <tr data-id="{{ $minera->id_minera }}">
                            <td>{{ $minera->id_minera }}</td>
                            <td>
                                <span class="view-mode">{{ $minera->nombre_minera }}</span>
                                <input class="edit-mode form-control form-control-sm d-none" type="text" value="{{ $minera->nombre_minera }}">
                            </td>
                            <td>
                                <span class="view-mode">{{ $minera->ruc }}</span>
                                <input class="edit-mode form-control form-control-sm d-none" type="text" value="{{ $minera->ruc }}">
                            </td>
                            <td>
                                <span class="view-mode">{{ $minera->direccion }}</span>
                                <input class="edit-mode form-control form-control-sm d-none" type="text" value="{{ $minera->direccion }}">
                            </td>
                            <td>{{ $minera->telefono_contacto }}</td>
                            <td>{{ $minera->correo_contacto }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm btn-editar" title="Editar"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-success btn-sm btn-guardar d-none" title="Guardar"><i class="fas fa-save"></i></button>
                                <button class="btn btn-secondary btn-sm btn-cancelar d-none" title="Cancelar"><i class="fas fa-times"></i></button>
                                <form action="{{ route('mineras.destroy', $minera->id_minera) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta minera?')" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay mineras registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ url('/home') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </div>
</div>

<!-- Offcanvas Nueva Minera -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNuevaMinera" aria-labelledby="offcanvasNuevaMineraLabel">
  <div class="offcanvas-header bg-primary text-white">
    <h5 class="offcanvas-title" id="offcanvasNuevaMineraLabel"><i class="fas fa-plus-circle"></i> Nueva Minera</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>
  <form class="offcanvas-body" action="{{ route('mineras.store') }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre_minera" class="form-label">Nombre de la Minera</label>
        <input type="text" class="form-control" id="nombre_minera" name="nombre_minera" required maxlength="100">
    </div>
    <div class="mb-3">
        <label for="ruc" class="form-label">RUC</label>
        <input type="text" class="form-control" id="ruc" name="ruc" maxlength="11" pattern="\d{11}" title="Debe contener 11 dígitos" required>
    </div>
    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" id="direccion" name="direccion" required>
    </div>
    <div class="mb-3">
        <label for="telefono_contacto" class="form-label">Teléfono</label>
        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" pattern="\d{9}" title="Debe contener 9 dígitos" required>
    </div>
    <div class="mb-3">
        <label for="correo_contacto" class="form-label">Correo</label>
        <input type="email" class="form-control" id="correo_contacto" name="correo_contacto" required>
    </div>
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Minera</button>
    </div>
  </form>
</div>

<!-- Estilos y scripts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background: #f4f6f9;
    }
    .card {
        border-radius: 1rem;
        border: none;
    }
    .card-header {
        border-radius: 1rem 1rem 0 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .table thead th {
        background: #e9ecef;
        color: #495057;
        font-weight: 600;
        border-top: none;
    }
    .table tbody tr {
        transition: background 0.3s;
    }
    .table tbody tr:hover {
        background: #f1f3f5;
    }
    .btn-info, .btn-danger, .btn-success, .btn-secondary, .btn-primary {
        border-radius: 0.5rem;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
    }
    .mb-3 input[type="text"], .mb-3 input[type="email"] {
        background: #f8fafc;
    }
    .alert {
        border-radius: 0.5rem;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscar = document.getElementById('buscarMinera');
    const tablaFilas = document.querySelectorAll('#tablaMineras tbody tr');

    // Restaurar búsqueda previa si existe
    if (localStorage.getItem('busquedaMinera')) {
        buscar.value = localStorage.getItem('busquedaMinera');
        filtrarMineras(buscar.value.trim().toLowerCase());
    }

    buscar.addEventListener('keyup', function() {
        const filtro = this.value.trim().toLowerCase();
        localStorage.setItem('busquedaMinera', filtro);
        filtrarMineras(filtro);
    });

    function filtrarMineras(filtro) {
        tablaFilas.forEach(function(row) {
            const nombre = row.cells[1]?.textContent.trim().toLowerCase() || '';
            if (nombre.includes(filtro)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Auto-cierre de alertas
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => el.remove());
    }, 5000);

    // Edición en línea
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            row.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
            row.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
            row.querySelector('.btn-editar').classList.add('d-none');
            row.querySelector('.btn-guardar').classList.remove('d-none');
            row.querySelector('.btn-cancelar').classList.remove('d-none');
        });
    });

    document.querySelectorAll('.btn-cancelar').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            row.querySelectorAll('.edit-mode').forEach((input, idx) => {
                input.value = row.querySelectorAll('.view-mode')[idx].textContent.trim();
                input.classList.add('d-none');
            });
            row.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
            row.querySelector('.btn-editar').classList.remove('d-none');
            row.querySelector('.btn-guardar').classList.add('d-none');
            row.querySelector('.btn-cancelar').classList.add('d-none');
        });
    });

    document.querySelectorAll('.btn-guardar').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const inputs = row.querySelectorAll('.edit-mode');
            const data = {
                nombre_minera: inputs[0].value,
                ruc: inputs[1].value,
                direccion: inputs[2].value,
                _token: '{{ csrf_token() }}'
            };
            fetch(`/mineras/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nombre_minera: inputs[0].value,
                    ruc: inputs[1].value,
                    direccion: inputs[2].value
                })
            })
            .then(resp => resp.json())
            .then(resp => {
                if (resp.success) {
                    row.querySelectorAll('.view-mode')[0].textContent = data.nombre_minera;
                    row.querySelectorAll('.view-mode')[1].textContent = data.ruc;
                    row.querySelectorAll('.view-mode')[2].textContent = data.direccion;
                    row.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));
                    row.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                    row.querySelector('.btn-editar').classList.remove('d-none');
                    row.querySelector('.btn-guardar').classList.add('d-none');
                    row.querySelector('.btn-cancelar').classList.add('d-none');
                } else {
                    alert('Error al guardar');
                }
            });
        });
    });
});
</script>
@endsection