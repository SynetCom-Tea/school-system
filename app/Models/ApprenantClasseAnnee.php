<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprenantClasseAnnee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['apprenant_id', 'classe_annee_id'];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function classe_annee()
    {
        return $this->belongsTo(ClasseAnnee::class);
    }
}
