<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;

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

     public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }  

    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class);
    }
    public function inscriptions()
    {
        return $this->hasMany(Cycle::class);
    }
    public function filiere_niveau_matiere_ues(): HasMany
    {
        return $this->hasMany(FiliereNiveauMatiereUe::class);
    }
}
