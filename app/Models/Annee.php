<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Scolarite\Entities\Frais;

class Annee extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'actif',
    ];

    public function getAnneeEnCours()
    {
        return $this->where('actif',1);
    }
    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class);
    }
    public function inscriptions()
    {
        return $this->hasMany(Cycle::class);
    }
    public function classeAnnees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }
}
