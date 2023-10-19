<?php

namespace Modules\Enseignement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EnseignantMatiere extends Model
{
    protected $fillable = ['matiere_id','enseignant_id'];
    use HasFactory;

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
}
