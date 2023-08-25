<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = ['matricule','nom','prenom','tel','mail'];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function versements(): HasMany
    {
        return $this->hasMany(Versement::class);
    }
}
