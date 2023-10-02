<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeFrais extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'libelle',
        'etablissement_id',

    ];
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    protected static function newFactory()
    {
        return \Modules\Scolarite\Database\factories\TypeFraisFactory::new();
    }
}
