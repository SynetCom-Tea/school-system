<?php

namespace App\Models;

use Modules\GestionNote\Entities\Note;
use Illuminate\Database\Eloquent\Model;
use Modules\Scolarite\Entities\Inscription;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Apprenant extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
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
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }
    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function apprenant_classe_annees(): HasMany
    {
        return $this->hasMany(ApprenantClasseAnnee::class);
    }
    
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
