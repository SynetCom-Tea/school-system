<?php

namespace Modules\Scolarite\Entities;

use App\Models\Annee;
use App\Models\Etablissement;
use App\Models\EtablissementSection;
use Modules\Scolarite\Entities\EtablissementTypeFrais;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Enseignement\Entities\Niveau;

class Frais extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'libelle',
        'montant',
        'annee_id',
        'etablissement_id',
        'niveau_id',
        'etablissement_type_frais_id'
    ];

    /* public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    } */
    public function etablissement_type_frais(): BelongsTo
    {
        return $this->belongsTo(EtablissementTypeFrais::class);
    }
    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function versements(): HasMany
    {
        return $this->hasMany(Versement::class);
    }
}
