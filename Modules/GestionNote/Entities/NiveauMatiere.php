<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveauMatiere extends Model
{
    use HasFactory;
    protected $fillable = ['niveaux_id', 'matieres_id','classe','annee'];

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
}
