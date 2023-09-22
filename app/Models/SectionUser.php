<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','etablissement_section_id'];
   
    public function etablissement_section(): BelongsTo
    {
        return $this->belongsTo(EtablissementSection::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
