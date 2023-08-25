<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Niveau extends Model
{
    use HasFactory;

    protected $fillable = ['code','libele'];

    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class);
    }
    
}
