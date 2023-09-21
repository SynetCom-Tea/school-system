<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprenantTuteur extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'apprenant_id',
        'tuteur_id',
    ];
    public function apprenant()
    {
        return $this->belongsTo('App\Models\Apprenant');
    }

    public function tuteur()
    {
        return $this->belongsTo('App\Models\Tuteur');
    }
}
