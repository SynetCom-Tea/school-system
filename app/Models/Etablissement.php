<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etablissement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'mail', 'adresse','type_etablissement_id', 'telephone', 'ville'];

    public function type_etablissement(): BelongsTo
    {
        return $this->belongsTo(TypeEtablissement::class);
    }

    public function salles(): HasMany
    {
        return $this->hasMany(Salle::class);
    }

    protected function telephone(): Attribute
    {
        return new Attribute(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    } 
}
