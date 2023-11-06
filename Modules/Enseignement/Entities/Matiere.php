<?php

namespace Modules\Enseignement\Entities;

use App\Models\EtablissementSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matiere extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['code', 'nom', 'etablissement_section_id'];

    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\MatiereFactory::new();
    }

    public function niveauMatieres(): HasMany
    {
        return $this->hasMany(NiveauMatiere::class);
    }

    public function etablissement_section(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function filiere_niveau_matiere_ues(): HasMany
    {
        return $this->hasMany(FiliereNiveauMatiereUe::class);
    }
}
