<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tuteur extends Model
{
    use HasFactory;

    protected $fillable = ['nom','prenom','tel','adresse'];
    
    public function apprenants(): HasMany
    {
        return $this->hasMany(Apprenant::class);
    }
}
