<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Filiere extends Model
{
    use HasFactory;

    protected $fillable = ['code','libele','departement_id','ecole_id','institut_id'];
    
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function ecole(): BelongsTo
    {
        return $this->belongsTo(Ecole::class);
    }

    public function institut(): BelongsTo
    {
        return $this->belongsTo(Institut::class);
    }

    public function frais(): HasMany
    {
        return $this->hasMany(Frais::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }
}
