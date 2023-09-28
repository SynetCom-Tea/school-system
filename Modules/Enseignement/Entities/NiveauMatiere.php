<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Niveau;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NiveauMatiere extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\NiveauMatiereFactory::new();
    }
    public function filiere_matiere_ue(): BelongsTo
    {
        return $this->belongsTo(FiliereMatiereUe::class);
    }
    
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
}
