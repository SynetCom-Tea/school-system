<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprenantClasse extends Model
{
    use HasFactory;
    protected $fillable = ['apprenant_id', 'classe_annee_id'];

    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function classe_annee()
    {
        return $this->belongsTo(ClasseAnnee::class);
    }
}
