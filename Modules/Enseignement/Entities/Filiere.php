<?php

namespace Modules\Enseignement\Entities;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filiere extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['code','name','etablissement_section_id','departement_id'];

    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\FiliereFactory::new();
    }
    public function cycle_filieres(): HasMany
    {
        return $this->hasMany(CycleFiliere::class);
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}
