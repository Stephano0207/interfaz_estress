<?php

namespace App\Http\Controllers;

use App\Exports\PredictionsExport;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class StressPredictionController extends Controller
{

    public function index(){
        return view("index");
    }

    public function showForm()
    {
            session(['form_start_time' => now()]);
        return view('stress_prediction.form');
    }

    public function predict(Request $request)
    {
            // Obtener hora de inicio de la sesión
        $startTime = session('form_start_time');
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
            // $response = Http::post('http://localhost:5000/predict', $input_data);
             $response = Http::post('https://proyectoprediccionestress-production.up.railway.app/predict', $input_data);


            if ($response->successful()) {
                // Guardar en la base de datos
                    $endTime = now();
                    $completionTime = $startTime->diffInSeconds($endTime);
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
        'edad' => $validated['edad'],
        'start_time' => $startTime,
        'end_time' => $endTime,
        'completion_seconds' => $completionTime
                ]);

 // Limpiar sesión
    $request->session()->forget('form_start_time');


                return back()->with([
                    'prediction' => $response->json()['prediction'],
                            'completion_time' => $this->formatDuration($completionTime),
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

    private function formatDuration($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

// public function list()
// {
//     $predictions = Prediction::orderBy('created_at', 'desc')->paginate(10);
//     return view('students.list', compact('predictions'));
// }

// public function list(Request $request)
// {
//     $query = Prediction::query();

//     if ($request->filled('carrera')) {
//         $query->where('carrera', $request->carrera);
//     }

//     if ($request->filled('stress_level')) {
//         $query->where('stress_level', $request->stress_level);
//     }

//     $predictions = $query->orderBy('created_at', 'desc')->paginate(10);

//     return view('students.list', [
//         'predictions' => $predictions,
//         'carreras' => Prediction::distinct('carrera')->pluck('carrera'),
//         'niveles' => ['Low', 'Moderate', 'High']
//     ]);
// }

public function list(Request $request)
{
    $query = Prediction::query(); // Si tienes relación con User

    // Búsqueda por rango de fechas
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $query->whereBetween('created_at', [
            Carbon::parse($request->fecha_inicio)->startOfDay(),
            Carbon::parse($request->fecha_fin)->endOfDay()
        ]);
    }

    // Búsqueda por fecha específica
    elseif ($request->filled('fecha')) {
        $query->whereDate('created_at', Carbon::parse($request->fecha));
    }

    // Resto de tus filtros existentes (carrera, nivel de estrés, etc.)
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
