<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Versement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle', 'date_versement', 'montant', 'etudiant_id', 'frais_id'];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function frais(): BelongsTo
    {
        return $this->belongsTo(Frais::class);
    }
}
