<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StressPredictionController extends Controller
{


       public function showForm()
    {
        return view('stress_prediction.form');
    }

    public function predict(Request $request)
    {
        $validated = $request->validate([
            'study_hours' => 'required|numeric|between:0,24',
            'extracurricular_hours' => 'required|numeric|between:0,24',
            'sleep_hours' => 'required|numeric|between:0,24',
            'social_hours' => 'required|numeric|between:0,24',
            'physical_activity_hours' => 'required|numeric|between:0,24',
            'gpa' => 'required|numeric|between:0,20'
        ]);

        // Datos para enviar a la API de Python
        $input_data = [
            'Study_Hours_Per_Day' => $validated['study_hours'],
            'Extracurricular_Hours_Per_Day' => $validated['extracurricular_hours'],
            'Sleep_Hours_Per_Day' => $validated['sleep_hours'],
            'Social_Hours_Per_Day' => $validated['social_hours'],
            'Physical_Activity_Hours_Per_Day' => $validated['physical_activity_hours'],
            'GPA' => $validated['gpa']
        ];

        // Opción 1: Llamar a API Flask
        try {
            $response = Http::post('http://localhost:5000/predict', $input_data);

            if ($response->successful()) {
                $prediction = $response->json()['prediction'];
                return back()->with('prediction', $prediction);
            } else {
                return back()->withErrors(['api_error' => 'Error from prediction API']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['api_error' => 'Could not connect to prediction service']);
        }

        // Opción 2: Ejecutar script Python directamente (ver alternativa más abajo)
    }


}
