<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\GestionNote\Entities\TypeEvaluation;

class RegimeEvaluation extends Model
{
    use HasFactory;

    public function type_evaluation()
    {
        return $this->belongsTo(TypeEvaluation::class);
    }

}
