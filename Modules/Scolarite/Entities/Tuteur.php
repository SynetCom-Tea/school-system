<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tuteur extends Model
{
    use HasFactory;

    protected $fillable = ['nom1','tel1','nom2','tel2'];
    
    public function etudiants(): HasMany
    {
        return $this->hasMany(Etudiant::class);
    }
}
