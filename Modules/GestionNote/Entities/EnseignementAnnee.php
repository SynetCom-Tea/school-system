<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignementAnnee extends Model
{
    use HasFactory;
    protected $fillable = ['enseignement_id', 'classe','annee'];

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function classe_annee()
    {
        return $this->belongsTo(ClasseAnnee::class);
    }

    public function niveau_matiere()
    {
        return $this->belongsTo(NiveauMatiere::class);
    }
}
