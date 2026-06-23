<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChefEtablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'etablissement_section_id',
        'created_at',
        'updated_at',
    ];

    public function etablissementSection()
    {
        return $this->belongsTo(EtablissementSection::class);
    }   
}
