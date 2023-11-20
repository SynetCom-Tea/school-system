<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriqueBulletin extends Model
{
    use HasFactory;
    protected $fillable = ['statut','apprenant_id', 'classe_annee_id', 
    'periode', 'matricule_apprenant', 'nom_prenom_apprenant', 'nom_classe',
    'total_coefficient', 'somme_note_generale', 'somme_note_generale_coefficient',
    'total_volume_horaire', 'moyenne_details_notes', 'rang'];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function classe_annee()
    {
        return $this->belongsTo(ClasseAnnee::class);
    }

    public function historique_notes(): HasMany
    {
        return $this->hasMany(HistoriqueNote::class);
    }
}
