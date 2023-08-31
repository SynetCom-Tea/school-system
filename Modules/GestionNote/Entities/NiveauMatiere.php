<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NiveauMatiere extends Model
{
    use HasFactory;
    protected $table = 'niveau_matieres';
    protected $primarykey = 'id';
    protected $fillable = ['id','niveaux_id', 'matieres_id','classe','annee'];

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function enseignement_annees(): BelongsToMany
    {
        return $this->belongsToMany(EnseignementAnnee::class);
    }
}
