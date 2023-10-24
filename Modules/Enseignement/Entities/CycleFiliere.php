<?php

namespace Modules\Enseignement\Entities;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;

class CycleFiliere extends Model
{
    use HasFactory;

    
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\CycleFiliereFactory::new();
    }
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }
    public function inscriptions()
    {
        return $this->hasMany(Cycle::class);
    }
    public function filiere_niveau_matiere_ues(): HasMany
    {
        return $this->hasMany(FiliereNiveauMatiereUe::class);
    }
}
