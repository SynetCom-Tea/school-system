<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClasseAnnee extends Model
{
    use HasFactory;

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function annee(): BelongsTo
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
