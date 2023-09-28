<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NiveauMatiere extends Model
{
    use HasFactory;

    protected $fillable = ['volume_horaire','coefficient','niveau_id','matiere_id'];
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\NiveauMatiereFactory::new();
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }  

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }  
}
