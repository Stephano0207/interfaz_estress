@extends('layouts.app')


@section('content')
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('predictions.list') }}">
            <div class="row g-3">
                <!-- Búsqueda por rango de fechas -->
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                           value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                           value="{{ request('fecha_fin') }}">
                </div>

                <!-- Búsqueda por fecha exacta (alternativa) -->
                <div class="col-md-4">
                    <label for="fecha" class="form-label">Fecha Exacta</label>
                    <input type="date" class="form-control" id="fecha" name="fecha"
                           value="{{ request('fecha') }}">
                </div>

                <!-- Tus filtros existentes -->
                <div class="col-md-4">
                    <label for="carrera" class="form-label">Carrera</label>
                    <select class="form-select" id="carrera" name="carrera">
                        <option value="">Todas</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera }}" {{ request('carrera') == $carrera ? 'selected' : '' }}>
                                {{ $carrera }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="stress_level" class="form-label">Nivel de Estrés</label>
                    <select class="form-select" id="stress_level" name="stress_level">
                        <option value="">Todos</option>
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel }}" {{ request('stress_level') == $nivel ? 'selected' : '' }}>
                                {{ $nivel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                    <a href="{{ route('predictions.list') }}" class="btn btn-secondary">
                        <i class="fas fa-undo me-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-list me-2"></i>Historial de Predicciones</h2>

         <a href="{{ route('predictions.export') }}" class="btn btn-success me-2">
            <i class="fas fa-file-excel me-1"></i> Exportar a Excel
        </a>
        <a href="{{ route('stress.form') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Predicción
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Carrera</th>
                            <th>Ciclo</th>
                            <th>Edad</th>
                            <th>Nivel de Estrés</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($predictions as $prediction)
                        <tr>
                            <td>{{ $prediction->nombres }}</td>
                            <td>{{ $prediction->apellidos }}</td>
                            <td>{{ $prediction->carrera }}</td>
                            <td>{{ $prediction->ciclo }}</td>
                            <td>{{ $prediction->edad }}</td>
                            <td>
                                <span class="badge bg-{{
                                    strtolower($prediction->Stress_Level) == 'high' ? 'danger' :
                                    (strtolower($prediction->Stress_Level) == 'moderate' ? 'warning' : 'success')
                                }}" >
                                    {{ $prediction->Stress_Level}}
                                </span>
                            </td>
                            <td>{{ $prediction->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay registros aún</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($predictions->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $predictions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .badge.bg-danger { background-color: #dc3545 !important; }
    .badge.bg-warning { color: #000 !important; }
    .form-label {
        font-weight: 500;
        font-size: 0.9rem;
    }
</style>
@endpush

@push('scripts')
<script>

</script>
@endpush
@endsection
