<?php

namespace App\Models;

use Modules\Scolarite\Entities\Frais;
use Illuminate\Database\Eloquent\Model;
use Modules\Scolarite\Entities\Inscription;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['libelle', 'actif', "etablissement_section_id", ];
    

    public static function getAnneeEnCours()
    {
        return self::where('actif', 1)->first();
    }
    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class);
    }
    public function inscriptions()
    {
        // return $this->hasMany(Cycle::class);
        return $this->hasMany(Inscription::class);
    }
    public function classeAnnees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }
    public function etablissementSection(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }
}
