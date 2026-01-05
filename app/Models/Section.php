<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Niveau;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle'];

    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }

    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class);
    }
}
