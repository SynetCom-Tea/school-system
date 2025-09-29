<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Filiere;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ecole extends Model
{
    use HasFactory;

    protected $fillable = ['code','libele'];

    public function filieres(): HasMany
    {
        return $this->hasMany(Filiere::class);
    }
}
