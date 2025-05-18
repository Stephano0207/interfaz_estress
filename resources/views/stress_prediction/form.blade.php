@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-3">Prediccion de Nivel de estress</h2>
        <p class="lead text-muted">Completa el siguiente formulario para medir tu nuvel de estress y enviarte unas recomendaciones personalizadas</p>
    </div>

    @if(session('prediction'))
    <div class="result-container mb-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-{{
                strtolower(session('prediction')) == 'high' ? 'danger' :
                (strtolower(session('prediction')) == 'moderate' ? 'warning' : 'success')
            }} text-white">
                <h4 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Resultado del Analisis</h4>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <div class="stress-level-display">
                            <div class="level-indicator level-{{ strtolower(session('prediction')) }}"></div>
                            <h3 class="mb-0">Nivel de estres: <strong>{{ session('prediction') }}</strong></h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="progress">
                            <div class="progress-bar bg-{{
                                strtolower(session('prediction')) == 'high' ? 'danger' :
                                (strtolower(session('prediction')) == 'moderate' ? 'warning' : 'success')
                            }}" role="progressbar" style="width: {{
                                strtolower(session('prediction')) == 'high' ? '100' :
                                (strtolower(session('prediction')) == 'moderate' ? '65' : '30')
                            }}%" aria-valuenow="{{
                                strtolower(session('prediction')) == 'high' ? '100' :
                                (strtolower(session('prediction')) == 'moderate' ? '65' : '30')
                            }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                @if(session('recommendations'))
                <div class="recommendations-box mt-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-lightbulb text-warning me-2"></i> Recomendacion Personalizada:
                    </h5>
                    <div class="recommendations-content">
                        {!! nl2br(e(session('recommendations'))) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('predict.stress') }}" class="needs-validation" novalidate>
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.1" class="form-control" id="study_hours" name="study_hours"
                                   value="{{ old('study_hours') }}" min="0" max="24" required>
                            <label for="study_hours">Study Hours Per Day</label>
                            @error('study_hours')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.1" class="form-control" id="extracurricular_hours" name="extracurricular_hours"
                                   value="{{ old('extracurricular_hours') }}" min="0" max="24" required>
                            <label for="extracurricular_hours">Extracurricular Hours</label>
                            @error('extracurricular_hours')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.1" class="form-control" id="sleep_hours" name="sleep_hours"
                                   value="{{ old('sleep_hours') }}" min="0" max="24" required>
                            <label for="sleep_hours">Sleep Hours Per Day</label>
                            @error('sleep_hours')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.1" class="form-control" id="social_hours" name="social_hours"
                                   value="{{ old('social_hours') }}" min="0" max="24" required>
                            <label for="social_hours">Social Hours Per Day</label>
                            @error('social_hours')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.1" class="form-control" id="physical_activity_hours" name="physical_activity_hours"
                                   value="{{ old('physical_activity_hours') }}" min="0" max="24" required>
                            <label for="physical_activity_hours">Physical Activity Hours</label>
                            @error('physical_activity_hours')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" step="0.01" class="form-control" id="gpa" name="gpa"
                                   value="{{ old('gpa') }}" min="0" max="20" required>
                            <label for="gpa">GPA</label>
                            @error('gpa')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-chart-bar me-2"></i> Predict Stress Level
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .result-container {
        animation: fadeIn 0.5s ease-in-out;
    }

    .recommendations-box {
        background-color: #f8f9fa;
        border-left: 4px solid var(--primary-color);
        padding: 1.5rem;
        border-radius: 0 8px 8px 0;
    }

    .recommendations-content {
        white-space: pre-line;
    }

    .stress-level-display {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .level-indicator {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }

    .level-high {
        background-color: var(--danger-color);
        box-shadow: 0 0 10px rgba(247, 37, 133, 0.5);
    }

    .level-moderate {
        background-color: var(--warning-color);
        box-shadow: 0 0 10px rgba(248, 150, 30, 0.5);
    }

    .level-low {
        background-color: var(--success-color);
        box-shadow: 0 0 10px rgba(76, 201, 240, 0.5);
    }

    .progress {
        height: 10px;
        border-radius: 5px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Validación del lado del cliente
    (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endpush
@endsection
