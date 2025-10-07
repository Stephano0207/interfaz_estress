<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyResponse;

class EncuestaController extends Controller
{
    /** Muestra el formulario */
    public function create()
    {
        // resources/views/students/encuesta.blade.php
        return view('students.encuesta');
    }

    /** Procesa y guarda la encuesta */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres'          => 'required|string|max:120',
            'apellidos'        => 'required|string|max:120',
            'carrera'          => 'required|string|max:120',
            'ciclo'            => 'required|integer|min:1|max:30',
            'edad'             => 'required|integer|min:15|max:100',
            'sexo'             => 'required|string|max:32',
            'email'            => 'nullable|email',
            'items'            => 'required|array|size:8',
            'items.*'          => 'required|integer|min:1|max:5',
            'total_score'      => 'required|integer|min:8|max:40',
            'duration_seconds' => 'nullable|integer|min:0',
            'observaciones'    => 'nullable|string|max:1000',
        ]);

        // Recalcular en servidor para evitar manipulación
        $sum = 0;
        for ($i = 1; $i <= 8; $i++) {
            $sum += (int)($data['items'][$i] ?? 0);
        }

        $payload = [
            'user_id'          => Auth::id(),
            'nombres'          => $data['nombres'],
            'apellidos'        => $data['apellidos'],
            'carrera'          => $data['carrera'],
            'ciclo'            => (int)$data['ciclo'],
            'edad'             => (int)$data['edad'],
            'sexo'             => $data['sexo'],
            'email'            => $data['email'] ?? null,
            'item1'            => (int)$data['items'][1],
            'item2'            => (int)$data['items'][2],
            'item3'            => (int)$data['items'][3],
            'item4'            => (int)$data['items'][4],
            'item5'            => (int)$data['items'][5],
            'item6'            => (int)$data['items'][6],
            'item7'            => (int)$data['items'][7],
            'item8'            => (int)$data['items'][8],
            'total_score'      => $sum,
            'duration_seconds' => $data['duration_seconds'] ?? null,
            'observaciones'    => $data['observaciones'] ?? null,
        ];

        SurveyResponse::create($payload);

        return redirect()
            ->route('survey.form')
            ->with('status', 'Encuesta registrada correctamente.');
    }
}
