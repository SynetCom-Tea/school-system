<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculte extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'libele'];
    
    public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }
}
