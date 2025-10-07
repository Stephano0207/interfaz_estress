<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $table = 'survey_responses';

    protected $fillable = [
        'user_id','nombres','apellidos','carrera','ciclo','edad','sexo','email',
        'item1','item2','item3','item4','item5','item6','item7','item8',
        'total_score','duration_seconds','observaciones'
    ];
}
