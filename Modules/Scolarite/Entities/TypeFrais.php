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
        'statut',

    ];
}
