<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['code','libele','faculte_id'];

    public function faculte(): BelongsTo
    {
        return $this->belongsTo(Faculte::class);
    }
    
    public function filieres(): HasMany
    {
        return $this->hasMany(Filiere::class);
    }
}
