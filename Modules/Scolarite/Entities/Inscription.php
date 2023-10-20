<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Apprenant;
use App\Models\Annee;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\Versement;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = ['code','date_inscription', 'apprenant_id', 'niveau_id','cycle_filiere_id', 'annee_id','statut'];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }
    public function cycleFiliere()
    {
        return $this->belongsTo(CycleFiliere::class);
    }
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }
    public function versements()
    {
        return $this->hasMany(Versement::class);
    }

    /* public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    } */

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
}
