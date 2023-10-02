<?php

namespace Modules\Scolarite\Entities;

use App\Models\Apprenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Versement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle', 'date_versement', 'montant', 'apprenant_id', 'frais_id'];

    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function frais(): BelongsTo
    {
        return $this->belongsTo(Frais::class);
    }
}
