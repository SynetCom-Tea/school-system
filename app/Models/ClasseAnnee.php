<?php

namespace App\Models;

use Modules\Emploi\Entities\Emploi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Enseignement\Entities\EnseignementAnnee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClasseAnnee extends Model
{
    use HasFactory;
    
    protected $fillable = ['annee_id','classe_id'];

    public function etablissement_section(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function enseignement_annees(): HasMany
    {
        return $this->hasMany(EnseignementAnnee::class);
    }

    public function emplois(): HasMany
    {
        return $this->hasMany(Emploi::class);
    }

    public function apprenants(): BelongsToMany
    {
        return $this->belongsToMany(Apprenant::class, 'apprenant_classe_annees')->wherePivotNull('deleted_at');
    }
}
