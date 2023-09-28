<?php

namespace Modules\Enseignement\Entities;

use App\Models\ClasseAnnee;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\NiveauMatiere;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnseignementAnnee extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Enseignement\Database\factories\EnseignementAnneeFactory::new();
    }

    public function classe_annee(): BelongsTo
    {
        return $this->belongsTo(ClasseAnnee::class);
    }

    public function niveau_matiere(): BelongsTo
    {
        return $this->belongsTo(NiveauMatiere::class);
    }
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
