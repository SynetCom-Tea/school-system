<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = ['matricule','nom','compte', 'prenom','NomComplet','sex','date_naissance','lieu_naissance','date_lieu_nais','telephone','etablissement_id'];

    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\EnseignantFactory::new();
    }

    public function enseignantAnnees(): HasMany
    {
        return $this->hasMany(EnseignantAnnee::class);
    }
}
