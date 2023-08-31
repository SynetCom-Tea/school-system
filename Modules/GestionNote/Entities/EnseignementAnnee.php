<?php

namespace Modules\GestionNote\Entities;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignementAnnee extends Model
{
    use HasFactory;
    protected $fillable = ['enseignant_id','code', 'classe_annee_id','niveau_matiere_id'];

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
