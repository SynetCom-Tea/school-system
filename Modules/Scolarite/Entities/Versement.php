<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Versement extends Model
{
    use HasFactory;

    protected $fillable = ['date_versement','montant','etudiant_id','frais_id'];
    
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function frais(): BelongsTo
    {
        return $this->belongsTo(Frais::class);
    }
}
