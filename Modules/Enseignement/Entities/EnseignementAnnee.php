<?php

namespace Modules\Enseignement\Entities;

use App\Models\ClasseAnnee;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\NiveauMatiere;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;

class EnseignementAnnee extends Model
{
    use HasFactory;

    protected $fillable = ['code','enseignant_id','niveau_matiere_id','classe_annee_id'];

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
    public function filiere_niveau_matiere_ue(): BelongsTo
    {
        return $this->belongsTo(FiliereNiveauMatiereUe::class);
    }
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
