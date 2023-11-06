<?php

namespace Modules\Scolarite\Entities;

use App\Models\EtablissementSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EtablissementTypeFrais extends Model
{
    use HasFactory;

    protected $fillable =  [
        'etablissement_section_id',
        'type_frais_id',
        'statut'
       
    ];
    public function etablissement_section()
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function type_frais()
    {
        return $this->belongsTo(TypeFrais::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Scolarite\Database\factories\EtablissementTypeFraisFactory::new();
    }
}
