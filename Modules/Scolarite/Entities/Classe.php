<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['libele'];

    public function classeAnnees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }
    
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }
}
