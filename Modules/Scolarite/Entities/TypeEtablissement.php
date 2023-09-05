<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeEtablissement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function etablissement(): HasMany
    {
        return $this->hasMany(Etablissement::class);
    }
}
