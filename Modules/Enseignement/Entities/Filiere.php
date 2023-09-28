<?php

namespace Modules\Enseignement\Entities;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\FiliereFactory::new();
    }
    public function cycle_filieres(): HasMany
    {
        return $this->hasMany(CycleFiliere::class);
    }
}
