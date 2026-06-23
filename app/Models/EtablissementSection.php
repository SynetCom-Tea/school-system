<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtablissementSection extends Model
{

    use HasFactory;
    protected $table = 'etablissement_section';
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

    public function chefEtablissements()
    {
        return $this->hasMany(ChefEtablissement::class);
    }
    
}
