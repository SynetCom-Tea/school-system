<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnseignantAnnee extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\EnseignantAnneeFactory::new();
    }

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function niveauMatiere(): BelongsTo
    {
        return $this->belongsTo(NiveauMatiere::class);
    }

    public function classeAnnee(): BelongsTo
    {
        return $this->belongsTo(ClasseAnnee::class);
    }
}
