<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EtablissementSection extends Model
{
    
    use HasFactory;
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
