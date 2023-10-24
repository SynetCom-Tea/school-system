<?php

namespace App\Models;

use App\Models\ClasseAnnee;
use App\Models\EtablissementSection;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Niveau;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classe extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'libelle',
        'etablissement_section_id',
        'niveau_id'
    ];
    public function etablissement_section(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
    public function cycle_filiere(): BelongsTo
    {
        return $this->belongsTo(CycleFiliere::class);
    }
    public function classe_annees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }
}
