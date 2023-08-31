<?php

namespace Modules\Emploi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Emploi\Database\factories\AbsenceFactory::new();
    }

    public function horaire(): BelongsTo
    {
        return $this->belongsTo(Horaire::class);
    }

    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }
}
