<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClasseAnnee extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut','date_fin','anneeScolaire_id','classe_id'];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function enseignantAnnees(): HasMany
    {
        return $this->hasMany(EnseignantAnnee::class);
    }

    public function emplois(): HasMany
    {
        return $this->hasMany(Emploi::class);
    }

    public function apprenants(): BelongsToMany
    {
        return $this->belongsToMany(Apprenant::class);
    }
}
