<?php

namespace Modules\Emploi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Emploi\Database\factories\SeanceFactory::new();
    }

    public function emploi(): BelongsTo
    {
        return $this->belongsTo(Emploi::class);
    }

    public function salle(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Salle::class);
    }

    public function horaire(): BelongsTo
    {
        return $this->belongsTo(Horaire::class);
    }
}
