<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnneeClasse extends Model
{
    use HasFactory;

    protected $fillable = ['date_debut','date_fin','annee_id','classe_id'];
    
    /* protected static function newFactory()
    {
        return \Modules\Scolarite\Database\factories\AnneeClasseFactory::new();
    } */
}
