<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Niveau extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'libelle',
        'section_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\NiveauFactory::new();
    }

    public function niveauMatieres(): HasMany
    {
        return $this->hasMany(NiveauMatiere::class);
    }
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

     public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }  

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class);
    }
}
