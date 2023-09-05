<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = ['date_inscription', 'apprenant_id', 'filiere_id', 'classe_id'];
    
    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }

    /* public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    } */

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
}
