<?php

namespace App\Models;

use App\Models\EtablissementSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    public function classeAnnees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }

    public function etablissement_section(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }

}