<?php

namespace Modules\Scolarite\Entities;

use App\Models\TypeDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EtablissementTypeDocument extends Model
{
    use HasFactory;

    protected $fillable =  [
        'etablissement_section_id',
        'type_document_id',
        'statut'
       
    ];
    public function etablissement_section()
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function type_document()
    {
        return $this->belongsTo(TypeDocument::class);
    }
    
}
