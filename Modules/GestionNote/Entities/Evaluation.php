<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Evaluation extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['date', 'pourcentage', 'statut', 'periode_id', 'type_evaluation_id'];


    public function type_evaluation()
    {
        return $this->belongsTo(TypeEvaluation::class);
    }

    public function enseignement_annee()
    {
        return $this->belongsTo(EnseignementAnnee::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
