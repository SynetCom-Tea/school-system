<?php

namespace Modules\Emploi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['heure_debut', 'heure_fin'];
    
    protected static function newFactory()
    {
        return \Modules\Emploi\Database\factories\HoraireFactory::new();
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }

    public function seance(): HasOne
    {
        return $this->hasOne(Seance::class);
    }
}
