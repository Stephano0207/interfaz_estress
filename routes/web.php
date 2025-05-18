<?php

use App\Http\Controllers\StressPredictionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/predict-stress', [StressPredictionController::class, 'showForm'])->name('stress.form');
Route::post('/predict-stress', [StressPredictionController::class, 'predict'])->name('predict.stress');
