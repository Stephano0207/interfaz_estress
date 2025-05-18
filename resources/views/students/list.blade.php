@extends('layouts.app')


@section('content')
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

</style>
@endpush

@push('scripts')
<script>

</script>
@endpush
@endsection
