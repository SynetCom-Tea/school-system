<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apprenant extends Model
{
    use HasFactory;

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function classeAnnees(): BelongsToMany
    {
        return $this->belongsToMany(ClasseAnnee::class);
    }
}
