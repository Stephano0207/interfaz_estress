<?php

namespace App\Http\Controllers;

use App\Exports\PredictionsExport;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class StressPredictionController extends Controller
{

    public function index(){
        return view("index");
    }

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
            'gpa' => 'required|numeric|between:0,20',
        // Nuevas validaciones
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'carrera' => 'required|string|max:100',
        'ciclo' => 'required|integer|between:1,10',
        'sexo' => 'required|in:Masculino,Femenino,Otro',
        'edad' => 'required|integer|between:15,60'

        ]);

        // Datos para enviar a la API de Python
        $input_data = [
            'Study_Hours_Per_Day' => $validated['study_hours'],
            'Extracurricular_Hours_Per_Day' => $validated['extracurricular_hours'],
            'Sleep_Hours_Per_Day' => $validated['sleep_hours'],
            'Social_Hours_Per_Day' => $validated['social_hours'],
            'Physical_Activity_Hours_Per_Day' => $validated['physical_activity_hours'],
            'GPA' => $validated['gpa'],

        ];

        // Opción 1: Llamar a API Flask
        try {
            $response = Http::post('http://localhost:5000/predict', $input_data);


            if ($response->successful()) {
                // Guardar en la base de datos
                Prediction::create([
                    'Study_Hours_Per_Day' => $validated['study_hours'],
                    'Extracurricular_Hours_Per_Day' => $validated['extracurricular_hours'],
                    'Sleep_Hours_Per_Day' => $validated['sleep_hours'],
                    'Social_Hours_Per_Day' => $validated['social_hours'],
                    'Physical_Activity_Hours_Per_Day' => $validated['physical_activity_hours'],
                    'GPA' => $validated['gpa'],
                    'Stress_Level' =>$response['prediction'],
                           // Nuevos campos
        'nombres' => $validated['nombres'],
        'apellidos' => $validated['apellidos'],
        'carrera' => $validated['carrera'],
        'ciclo' => $validated['ciclo'],
        'sexo' => $validated['sexo'],
        'edad' => $validated['edad']
                ]);




                return back()->with([
                    'prediction' => $response->json()['prediction'],
                    'recommendations' => $response->json()['recommendations'] ?? null,
                    'success'=> 'Prediccion registrada correctamente'
                ]);
            } else {
                return back()->withErrors(['api_error' => 'Error from prediction API']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['api_error' => 'Could not connect to prediction service']);
        }

    }


// public function list()
// {
//     $predictions = Prediction::orderBy('created_at', 'desc')->paginate(10);
//     return view('students.list', compact('predictions'));
// }

public function list(Request $request)
{
    $query = Prediction::query();

    if ($request->filled('carrera')) {
        $query->where('carrera', $request->carrera);
    }

    if ($request->filled('stress_level')) {
        $query->where('stress_level', $request->stress_level);
    }

    $predictions = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('students.list', [
        'predictions' => $predictions,
        'carreras' => Prediction::distinct('carrera')->pluck('carrera'),
        'niveles' => ['Low', 'Moderate', 'High']
    ]);
}
public function export(Excel $excel)
{
    // return $excel->download(new PredictionsExport, 'predicciones_estres.xlsx');
    return Excel::download(new PredictionsExport, 'predicciones.xlsx');
}

}
