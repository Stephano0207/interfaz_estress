<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StressPredictionController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EncuestaController;

Route::middleware(['auth'])->group(function () {
    Route::get('/encuesta', [EncuestaController::class, 'create'])->name('survey.form');
    Route::post('/encuesta', [EncuestaController::class, 'store'])->name('survey.store');
});



  Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login.web');
// Para psycologo
Route::middleware(['auth','role:admin,psychologist'])->group(function(){
    Route::get('/index', [StressPredictionController::class,'index'])->name("predictions.index");
   Route::get( '/predicciones', [StressPredictionController::class, 'list'])->name('predictions.list');
   Route::get('/predicciones/exportar', [StressPredictionController::class, 'export'])
    ->name('predictions.export');
});

//Para studiante
Route::middleware(['auth','role:admin,student'])->group(function(){
    Route::get('/index', [StressPredictionController::class,'index'])->name("predictions.index");

Route::get('/predict-stress', [StressPredictionController::class, 'showForm'])->name('stress.form');
Route::post('/predict-stress', [StressPredictionController::class, 'predict'])->name('predict.stress');
});

// Rutas solo para admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/index', [StressPredictionController::class,'index'])->name("predictions.index");

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
