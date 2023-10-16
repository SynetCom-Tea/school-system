<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date_debut',
        'date_fin',
        'heure_debut',
        'heure_fin',
        'type_activite',
        'description',
        'statut'
    ];

    
}
