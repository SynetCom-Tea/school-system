<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apprenant extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sex',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'adresse',
        'etablissement_id',
    ];
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function apprenantTuteurs(): HasMany
    {
        return $this->hasMany(ApprenantTuteur::class);
    }
    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function classeAnnees(): BelongsToMany
    {
        return $this->belongsToMany(ClasseAnnee::class);
    }
}
