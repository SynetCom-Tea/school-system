<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apprenant extends Model
{
    use HasFactory;

    protected $fillable = ['matricule','nom','prenom','tel','mail','sexe','dateNaiss','lieuNaiss','photo'];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function versements(): HasMany
    {
        return $this->hasMany(Versement::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function classeAnnees(): BelongsToMany
    {
        return $this->belongsToMany(ClasseAnnee::class);
    }
}
