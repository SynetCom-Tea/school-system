<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EtablissementFilliere extends Model
{
    protected $fillable = ['code'];
    use HasFactory;

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function filliere(): BelongsTo
    {
        return $this->belongsTo(Filliere::class);
    }
}
