<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnneeClasse extends Model
{
    use HasFactory;

    protected $fillable = ['date_debut','date_fin','annee_id','classe_id'];

    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
    
    /* protected static function newFactory()
    {
        return \Modules\Scolarite\Database\factories\AnneeClasseFactory::new();
    } */
}
