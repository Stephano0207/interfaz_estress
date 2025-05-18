<?php

use App\Http\Controllers\StressPredictionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StressPredictionController::class,'index'])->name("predictions.index");
Route::get('/predict-stress', [StressPredictionController::class, 'showForm'])->name('stress.form');
Route::post('/predict-stress', [StressPredictionController::class, 'predict'])->name('predict.stress');
Route::get('/predicciones', [StressPredictionController::class, 'list'])->name('predictions.list');
Route::get('/predicciones/exportar', [StressPredictionController::class, 'export'])
    ->name('predictions.export');
