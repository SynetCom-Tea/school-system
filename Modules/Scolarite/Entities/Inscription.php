<?php

namespace Modules\Scolarite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Apprenant;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = ['date_inscription', 'apprenant_id', 'filiere_id', 'niveau_id', 'annee_id'];

    public function apprenant(): BelongsTo
    {
        return $this->belongsTo(Apprenant::class);
    }
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }
    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    /* public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    } */

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }
}
