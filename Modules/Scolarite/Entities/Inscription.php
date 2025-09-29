<?php

namespace Modules\Scolarite\Entities;

use App\Models\Annee;
use App\Models\Apprenant;
use App\Models\ClasseAnnee;
use Modules\Scolarite\Entities\Frais;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\Versement;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = ['code','date_inscription', 'apprenant_id', 'niveau_id','cycle_filiere_id', 'annee_id','statut', 'classe_annee_id'];

     // Ajoutez cette relation
    public function classeAnnee()
    {
        return $this->belongsTo(ClasseAnnee::class, 'classe_annee_id');
    }
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
    

    public function frais()
    {
        return $this->hasOne(Frais::class, 'niveau_id', 'niveau_id');
    }

    

}
