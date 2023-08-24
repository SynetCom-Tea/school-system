<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignementAnnee extends Model
{
    use HasFactory;
    protected $fillable = ['enseignement_id', 'classe','annee'];

    public function Enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
