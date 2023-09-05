<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle'];

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }

    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class);
    }
}
