<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FiliereNiveauMatiereUe extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\EnseignementAnneeFactory::new();
    }
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
    public function cycle_filiere(): BelongsTo
    {
        return $this->belongsTo(CycleFiliere::class);
    }
}
