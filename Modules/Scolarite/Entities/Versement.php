<?php

namespace Modules\Scolarite\Entities;

use App\Models\Apprenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Versement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle', 'date_versement', 'montant', 'inscription_id', 'frais_id'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }
    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function frais(): BelongsTo
    {
        return $this->belongsTo(Frais::class);
    }
}
