<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Enseignement\Entities\EnseignementAnnee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiliereNiveauMatiereUe extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['volume_horaire','coefficient','cycle_filiere_id','matiere_id','niveau_id','ue_id'];

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
    public function ue(): BelongsTo
    {
        return $this->belongsTo(Ue::class);
    }
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
    public function enseignement_annees(): HasMany
    {
        return $this->hasMany(EnseignementAnnee::class);
    }
}
