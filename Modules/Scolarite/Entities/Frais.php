<?php

namespace Modules\Scolarite\Entities;

use App\Models\EtablissementSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Enseignement\Entities\Niveau;

class Frais extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle', 'montant', 'niveau_id'];

    /* public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    } */
    public function etablissementSections(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
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
