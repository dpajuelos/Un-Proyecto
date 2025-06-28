<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .modal_editar {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal_editar.show {
            display: flex;
        }

        .modal_editar .container {
            background: #fff;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            position: relative;
            max-height: 90vh;
            /* Limita la altura máxima */
            overflow-y: auto;
            /* Habilita el scroll vertical */
        }

        .modal_editar .btn-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Gestión de Citas
                        </h4>

                        <!-- Botón Nueva Cita -->
                        <a href="javascript:void(0);" class="btn btn-primary" onclick="abrirModalNuevaCita()">
                            <i class="fas fa-plus me-1"></i>
                            Nueva Cita
                        </a>
                        <a href="{{ url('/home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Filtros -->
                        <form method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="pendiente"
                                            {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmada"
                                            {{ request('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada
                                        </option>
                                        <option value="cancelada"
                                            {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                        <option value="reprogramada"
                                            {{ request('estado') == 'reprogramada' ? 'selected' : '' }}>Reprogramada
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" name="fecha" class="form-control"
                                        value="{{ request('fecha') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Buscar</label>
                                    <input type="text" name="buscar" class="form-control"
                                        placeholder="ID Rep o ID Rep Sus" value="{{ request('buscar') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="fas fa-search"></i> Filtrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Mensajes -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Tabla de Citas -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Representante</th>
                                        <th>DNI</th>
                                        <th>Cargo</th>
                                        <th>Fecha Original</th>
                                        <th> Hora Original</th>
                                        <th>Nueva Fecha</th>
                                        <th>Nueva Hora</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($citas as $cita)
                                        <tr>

                                            <td>
                                                @if ($cita->representantePrincipal)
                                                    {{ $cita->representantePrincipal->persona->nombres ?? '' }}
                                                    {{ $cita->representantePrincipal->persona->apellidos ?? '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cita->representantePrincipal)
                                                    {{ $cita->representantePrincipal->persona->dni ?? '' }}
                                                @endif
                                            </td>
                                            <td>{{ $cita->representantePrincipal->cargo ?? '' }}</td>
                                            <td>{{ $cita->fecha ? \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>{{ $cita->hora ? \Carbon\Carbon::parse($cita->hora)->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                {{ $cita->fecha_nue ? \Carbon\Carbon::parse($cita->fecha_nue)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ $cita->hora_nue ? \Carbon\Carbon::parse($cita->hora_nue)->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @switch($cita->estado)
                                                        @case('pendiente') bg-warning @break
                                                        @case('confirmada') bg-success @break
                                                        @case('cancelada') bg-danger @break
                                                        @case('reprogramada') bg-info @break
                                                    @endswitch
                                                ">
                                                    {{ ucfirst($cita->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('citas.show', $cita) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                  
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning"
                                                        onclick="abrirModalEditarCita(
                                                    {{ $cita->id_cita }},
                                                    {{ $cita->id_rep }},
                                                    {{ $cita->id_rep_sus ?? 'null' }},
                                                    '{{ $cita->fecha }}',
                                                    '{{ $cita->hora }}',
                                                    '{{ $cita->estado }}',
                                                    '{{ $cita->representantePrincipal->persona->nombres ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->apellidos ?? '' }}',
                                                    '{{ $cita->representantePrincipal->persona->dni ?? '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->nombres : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->apellidos : '' }}',
                                                    '{{ $cita->representanteSustituto ? $cita->representanteSustituto->persona->dni : '' }}'
                                                    )">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmarEliminar({{ $cita->id_cita }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No hay citas registradas</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        {{ $citas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar esta cita?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="formEliminar" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal_editar" id="modalEditarCita">
        <div class="container py-4">
            <button type="button" class="btn-close" onclick="cerrarModalEditarCita()"></button>
            <h2>Editar Cita</h2>
            <form id="formEditarCita" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3" style="display: none">
                    <label for="id_rep" class="form-label">ID Representante</label>
                    <input type="number" class="form-control" id="input_id_rep" name="id_rep" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre Representante</label>
                    <input type="text" class="form-control" id="input_nombre_rep" name="nombre_rep" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellido Representante</label>
                    <input type="text" class="form-control" id="input_apellido_rep" name="apellido_rep" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">DNI Representante</label>
                    <input type="text" class="form-control" id="input_dni_rep" name="dni_rep" required>
                </div>
                <div class="mb-3" style="display: none">
                    <label for="id_rep_sus" class="form-label">ID Sustituto</label>
                    <input type="number" class="form-control" id="input_id_rep_sus" name="id_rep_sus">
                </div>
                <div id="sustitutoCampos">
                    <div class="mb-3">
                        <label class="form-label">Nombre Sustituto</label>
                        <input type="text" class="form-control" id="input_nombre_sus" name="nombre_sus">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido Sustituto</label>
                        <input type="text" class="form-control" id="input_apellido_sus" name="apellido_sus">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">DNI Sustituto</label>
                        <input type="text" class="form-control" id="input_dni_sus" name="dni_sus">
                    </div>
                </div>
                <div id="noSustituto" class="mb-3" style="display:none;">
                    <span class="text-muted">No se añadió sustituto.</span>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="input_fecha" name="fecha" required>
                </div>
                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" class="form-control" id="input_hora" name="hora" required>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="input_estado" name="estado" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="cancelada">Cancelada</option>
                        <option value="reprogramada">Reprogramada</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarCita()">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal Nueva Cita -->
    <div class="modal_editar" id="modalNuevaCita">
        <div class="container py-4">
            <button type="button" class="btn-close" onclick="cerrarModalNuevaCita()"></button>
            <h2>Nueva Cita</h2>
            <form id="formNuevaCita" action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nuevo_id_rep" class="form-label">Representante</label>
                            <select class="form-select" id="nuevo_id_rep" name="id_rep" required>
                                <option value="">Seleccione un representante</option>
                                @foreach($representantes as $rep)
                                    <option value="{{ $rep->id }}">{{ $rep->persona->nombres }} {{ $rep->persona->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="nuevo_fecha" name="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_hora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="nuevo_hora" name="hora" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nuevo_id_rep_sus" class="form-label">Representante Sustituto (opcional)</label>
                            <select class="form-select" id="nuevo_id_rep_sus" name="id_rep_sus">
                                <option value="">Ninguno</option>
                                @foreach($representantes as $rep)
                                    <option value="{{ $rep->id }}">{{ $rep->persona->nombres }} {{ $rep->persona->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_estado" class="form-label">Estado</label>
                            <select class="form-select" id="nuevo_estado" name="estado" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="reprogramada">Reprogramada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cita</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarModalNuevaCita()">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal Crear Cita -->
    <div class="modal fade" id="crearCitaModal" tabindex="-1" aria-labelledby="crearCitaLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('citas.store') }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="crearCitaLabel">Crear Cita</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="id_rep" class="form-label">Representante Principal</label>
                <select class="form-select" name="id_rep" required>
                  <option value="">Seleccione...</option>
                  @foreach($representantes as $rep)
                    <option value="{{ $rep->id }}">{{ $rep->persona->nombres }} {{ $rep->persona->apellidos }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="id_rep_sus" class="form-label">Representante Sustituto</label>
                <select class="form-select" name="id_rep_sus">
                  <option value="">Ninguno</option>
                  @foreach($representantes as $rep)
                    <option value="{{ $rep->id }}">{{ $rep->persona->nombres }} {{ $rep->persona->apellidos }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" required>
              </div>
              <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" name="hora" required>
              </div>
              <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" name="estado" required>
                  <option value="pendiente">Pendiente</option>
                  <option value="confirmada">Confirmada</option>
                  <option value="cancelada">Cancelada</option>
                  <option value="reprogramada">Reprogramada</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Crear</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarEliminar(id) {
            document.getElementById('formEliminar').action = '/citas/' + id;
            new bootstrap.Modal(document.getElementById('modalEliminar')).show();
        }

        function abrirModalEditarCita(id_cita, id_rep, id_rep_sus, fecha, hora, estado, nombre_rep, apellido_rep, dni_rep,
            nombre_sus, apellido_sus, dni_sus) {
            document.getElementById('input_id_rep').value = id_rep;
            document.getElementById('input_nombre_rep').value = nombre_rep || '';
            document.getElementById('input_apellido_rep').value = apellido_rep || '';
            document.getElementById('input_dni_rep').value = dni_rep || '';
            document.getElementById('input_id_rep_sus').value = id_rep_sus || '';
            document.getElementById('input_fecha').value = fecha;
            document.getElementById('input_hora').value = hora;
            document.getElementById('input_estado').value = estado;
            document.getElementById('formEditarCita').action = '/citas/' + id_cita;

            if (id_rep_sus && id_rep_sus !== 'null') {
                document.getElementById('sustitutoCampos').style.display = '';
                document.getElementById('noSustituto').style.display = 'none';
                document.getElementById('input_nombre_sus').value = nombre_sus || '';
                document.getElementById('input_apellido_sus').value = apellido_sus || '';
                document.getElementById('input_dni_sus').value = dni_sus || '';
            } else {
                document.getElementById('sustitutoCampos').style.display = 'none';
                document.getElementById('noSustituto').style.display = '';
                document.getElementById('input_nombre_sus').value = '';
                document.getElementById('input_apellido_sus').value = '';
                document.getElementById('input_dni_sus').value = '';
            }
            document.getElementById('modalEditarCita').classList.add('show');
        }

        function cerrarModalEditarCita() {
            document.getElementById('modalEditarCita').classList.remove('show');
        }

        function abrirModalNuevaCita() {
            document.getElementById('formNuevaCita').reset();
            document.getElementById('modalNuevaCita').classList.add('show');
        }

        function cerrarModalNuevaCita() {
            document.getElementById('modalNuevaCita').classList.remove('show');
        }
    </script>

</body>

</html>
