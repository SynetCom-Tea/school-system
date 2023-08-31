<?php

namespace Modules\GestionNote\Entities;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignementAnnee extends Model
{
    use HasFactory;
    protected $fillable = ['enseignement_id','code', 'classe','annee','niveau_matiere_id'];

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function niveau_matiere(): BelongsTo
    {
        return $this->belongsTo(NiveauMatiere::class);
    }
}
