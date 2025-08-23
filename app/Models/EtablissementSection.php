<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtablissementSection extends Model
{

    use HasFactory, SoftDeletes;
     // AJOUTEZ CETTE LIGNE POUR SPÉCIFIER LE NOM DE LA TABLE
    protected $table = 'etablissement_section';
    // AJOUTEZ CETTE LIGNE POUR SPÉCIFIER LES CHAMPS FILLABLES
    // Vous pouvez ajouter d'autres champs si nécessaire
    
    protected $fillable =  [
        'code',
        'regime_evaluation_id',
        'etablissement_id',
        'section_id',
        'systeme_lmd_id',
        'configuration'
    ];
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }
    
}
