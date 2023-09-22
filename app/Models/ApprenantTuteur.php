<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Scolarite\Entities\Tuteur;

class ApprenantTuteur extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'apprenant_id',
        'tuteur_id',
    ];
    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class, 'apprenant_id');
    }

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class, 'tuteur_id');
    }
}
