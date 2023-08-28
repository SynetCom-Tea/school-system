<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etablissement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'mail', 'adresse','type_etablissement_id', 'telephone', 'ville'];

    public function type_etablissement(): BelongsTo
    {
        return $this->belongsTo(TypeEtablissement::class);
    }
}
