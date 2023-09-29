<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Niveau;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NiveauMatiere extends Model
{
    use HasFactory;

    protected $fillable = ['volume_horaire', 'coefficient', 'niveau_id', 'matiere_id'];

    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\NiveauMatiereFactory::new();
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
    public function filiere_matiere_ue(): BelongsTo
    {
        return $this->belongsTo(FiliereMatiereUe::class);
    }
}
