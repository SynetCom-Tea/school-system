<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'libele'];

    public function anneeClasses(): HasMany
    {
        return $this->hasMany(AnneeClasse::class);
    }
    
}
