<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Filiere;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cycle extends Model
{
    use HasFactory;
    public function filieres(): HasMany
    {
        return $this->hasMany(Filiere::class);
    }
}
