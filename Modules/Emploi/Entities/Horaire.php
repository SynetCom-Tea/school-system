<?php

namespace Modules\Emploi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['heure_debut', 'heure_fin'];
    
    protected static function newFactory()
    {
        return \Modules\Emploi\Database\factories\HoraireFactory::new();
    }
}
