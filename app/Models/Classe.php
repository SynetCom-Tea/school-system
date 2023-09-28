<?php

namespace App\Models;

use App\Models\ClasseAnnee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'libelle', 'etablissement_section_id','niveau_id'];

    public function classeAnnees(): HasMany
    {
        return $this->hasMany(ClasseAnnee::class);
    }
}
