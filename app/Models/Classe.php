<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Enseignement\Entities\Niveau;

class Classe extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'libelle',
        'etablissement_section_id',
        'niveau_id'
    ];
    public function etablissementSection(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
    public function classeAnnees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }
}
