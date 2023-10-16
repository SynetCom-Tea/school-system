<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\ApprenantTuteur;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tuteur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'prenom', 'telephone', 'adresse', 'email','sexe'];
    public function apprenantTuteurs(): HasMany
    {
        return $this->hasMany(ApprenantTuteur::class);
    }

    // public function apprenants(): HasMany
    // {
    //     return $this->hasMany(Apprenant::class);
    // }
}
