<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Enseignement\Entities\EnseignementAnnee;

class ClasseAnnee extends Model
{
    use HasFactory;

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function enseignementtAnnees(): HasMany
    {
        return $this->hasMany(EnseignementAnnee::class);
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
