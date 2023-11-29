<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriqueNote extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['historique_bulletin_id', 'nom_eu', 'nom_matiere',
     'coefficient', 'note_de_classe', 'note_de_classe_coefficiente', 'note_de_composition',
      'note_de_composition_coefficiente', 'moyenne', 'moyenne_coefficiente',
      'note_origine_devoir', 'note_origine_examen', 'note_devoir_pourcentage', 'note_examen_pourcentage',
      'volume_horaire_matiere', 'note_generale', 'note_generale_coefficiente', 'note', 'notation_matiere', 'ue_id', 'matiere_id'
        ];

    public function historique_bulletin(): BelongsTo
    {
        return $this->belongsTo(HistoriqueBulletin::class);
    }
}
