{{-- resources/views/encuesta.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Encuesta de Estrés (8 ítems)
        </h2>
        <div>
            <a href="{{ route('predictions.list') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <form id="frm-encuesta" method="POST" action="{{ route('survey.store') }}">
        @csrf

        {{-- ===== Datos del estudiante ===== --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-user me-2"></i>Datos del estudiante
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Carrera</label>
                        <input type="text" name="carrera" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">N.° de Ciclo</label>
                        <input type="number" name="ciclo" min="1" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Edad</label>
                        <input type="number" name="edad" min="15" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sexo</label>
                        <select name="sexo" class="form-select" required>
                            <option value="">Seleccionar…</option>
                            <option>Femenino</option>
                            <option>Masculino</option>
                            <option>Otro / Prefiero no decirlo</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Correo (opcional)</label>
                        <input type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com">
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Encuesta Likert 1–5 ===== --}}
        @php
            $preguntas = [
                'Me cuesta concentrarme al estudiar o en clase.',
                'Me siento abrumado/a por mis tareas académicas.',
                'Duermo menos de lo que necesito para rendir bien.',
                'Me irrito o frustro con facilidad.',
                'Siento que no tengo control sobre mi carga académica.',
                'Me preocupa constantemente no llegar a las fechas límite.',
                'Tengo molestias físicas relacionadas al estrés (dolor de cabeza, cuello, etc.).',
                'Me resulta difícil desconectarme y relajarme.',
            ];
        @endphp

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <i class="fas fa-check-double me-2"></i>Responde del <strong>1</strong> al <strong>5</strong>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    1 = Nunca / Muy en desacuerdo &nbsp;|&nbsp;
                    3 = A veces / Neutral &nbsp;|&nbsp;
                    5 = Siempre / Muy de acuerdo
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:50%">Ítem</th>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">5</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($preguntas as $idx => $texto)
                            @php $num = $idx + 1; @endphp
                            <tr>
                                <td><strong>{{ $num }}.</strong> {{ $texto }}</td>
                                @for($v=1; $v<=5; $v++)
                                    <td class="text-center">
                                        <input type="radio"
                                               class="form-check-input"
                                               name="items[{{ $num }}]"
                                               value="{{ $v }}"
                                               @if($v===1) required @endif>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Resumen en vivo --}}
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="small text-muted">Puntaje total</div>
                                    <div id="lblTotal" class="fs-4 fw-semibold">0 / 40</div>
                                </div>
                                <div>
                                    <div class="small text-muted">Nivel estimado</div>
                                    <span id="lblNivel" class="badge bg-secondary">Pendiente</span>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height:10px;">
                                <div id="barTotal" class="progress-bar" role="progressbar" style="width:0%"></div>
                            </div>
                            <input type="hidden" name="total_score" id="total_score" value="0">
                            <input type="hidden" name="duration_seconds" id="duration_seconds" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Observaciones (opcional)</label>
                        <textarea name="observaciones" class="form-control" rows="3"
                                  placeholder="Comentarios que quieras agregar…"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Acciones ===== --}}
        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">
                <i class="fas fa-eraser me-1"></i> Limpiar
            </button>
            <button id="btnSubmit" type="submit" class="btn btn-success" disabled>
                <i class="fas fa-save me-1"></i> Guardar respuestas
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .table td, .table th { vertical-align: middle; }
</style>
@endpush

@push('scripts')
<script>
(() => {
    const totalItems = 8;
    const maxTotal   = totalItems * 5;
    const radios     = document.querySelectorAll('input[type="radio"][name^="items["]');
    const lblTotal   = document.getElementById('lblTotal');
    const lblNivel   = document.getElementById('lblNivel');
    const barTotal   = document.getElementById('barTotal');
    const totalInput = document.getElementById('total_score');
    const btnSubmit  = document.getElementById('btnSubmit');
    const durInput   = document.getElementById('duration_seconds');

    const startAt = Date.now();
    let currentSum = 0;

    function calc() {
        let sum = 0, answered = 0;
        for (let i = 1; i <= totalItems; i++) {
            const checked = document.querySelector('input[name="items['+i+']"]:checked');
            if (checked) { sum += parseInt(checked.value); answered++; }
        }
        currentSum = sum;

        // Texto total + barra
        lblTotal.textContent = `${sum} / ${maxTotal}`;
        const pct = Math.round((sum / maxTotal) * 100);
        barTotal.style.width = pct + '%';

        // Nivel simple por rangos (ajústalo si deseas)
        let nivel = 'Bajo', badge = 'success';
        if (sum >= 29) { nivel = 'Alto'; badge = 'danger'; }
        else if (sum >= 17) { nivel = 'Moderado'; badge = 'warning'; }
        lblNivel.textContent = nivel;
        lblNivel.className = `badge bg-${badge}`;

        totalInput.value = sum;

        // Habilitar envío solo si respondió todo
        btnSubmit.disabled = (answered !== totalItems);
    }

    radios.forEach(r => r.addEventListener('change', calc));
    calc();

    // Duración al enviar
    document.getElementById('frm-encuesta').addEventListener('submit', () => {
        durInput.value = Math.floor((Date.now() - startAt) / 1000);
        totalInput.value = currentSum;
    });
})();
</script>
@endpush
@endsection
