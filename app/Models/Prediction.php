<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
      protected $table = 'prediction'; // Especifica el nombre de la tabla
    protected $fillable = [
        'Study_Hours_Per_Day',
        'Extracurricular_Hours_Per_Day',
        'Sleep_Hours_Per_Day',
        'Social_Hours_Per_Day',
        'Physical_Activity_Hours_Per_Day',
        'GPA',
        'Stress_Level'
    ];

    protected $casts = [
        'Study_Hours_Per_Day' => 'float',
        'Extracurricular_Hours_Per_Day' => 'float',
        'Sleep_Hours_Per_Day' => 'float',
        'Social_Hours_Per_Day' => 'float',
        'Physical_Activity_Hours_Per_Day' => 'float',
        'GPA' => 'float'
    ];

    public $timestamps = false; // Desactiva los timestamps


}
