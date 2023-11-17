<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriqueNote extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['historique_bulletin_id', 'nom_matiere', 'coefficient', 'note_de_classe', 'note_de_classe_coefficiente', 'note_de_composition', 'note_de_composition_coefficiente', 'moyenne', 'moyenne_coefficiente'];

    public function historiqur_bulletin(): BelongsTo
    {
        return $this->belongsTo(HistoriqueBulletin::class);
    }
}
