<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faculte extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'libelle','etablissement_id'];

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    
    public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }
}
