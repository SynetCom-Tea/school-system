<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;
    
    protected $fillable =  [
        'etablissement_section_id',
        'nbre_limite_eleve_par_classe',
        'statut'
       
    ];
    public function etablissement_section()
    {
        return $this->belongsTo(EtablissementSection::class);
    }
}
