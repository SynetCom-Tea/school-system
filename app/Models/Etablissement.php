<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Modules\Enseignement\Entities;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etablissement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'adresse','type_etablissement_id','systeme_lmd_id', 'telephone', 'ville', 'logo'];

    public function type_etablissement(): BelongsTo
    {
        return $this->belongsTo(TypeEtablissement::class);
    }

    public function salles(): HasMany
    {
        return $this->hasMany(Salle::class);
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class);
    }

    protected function telephone(): Attribute
    {
        return new Attribute(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    } 
}
