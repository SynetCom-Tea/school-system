<?php

namespace Modules\Emploi\Entities;

use App\Exceptions\AucuneAnneeScolaire;
use App\Models\Annee;
use App\Models\ClasseAnnee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emploi extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'date_debut', 'date_fin', 'classe_annee_id'];
    
    protected static function newFactory()
    {
        return \Modules\Emploi\Database\factories\EmploiFactory::new();
    }

    public function classeAnnee(): BelongsTo
    {
        return $this->belongsTo(ClasseAnnee::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }

    public static function getEmploisBySectionAndEtablissement($sectionId, $etablissementId, $classe)
    {
        //dd($sectionId, $etablissementId, $classeAnneeId, $classe);
        return Emploi::join('classe_annees', 'emplois.classe_annee_id', '=', 'classe_annees.id')
            ->join('classes', 'classe_annees.classe_id', '=', 'classes.id')
            ->join('etablissement_section', 'classes.etablissement_section_id', '=', 'etablissement_section.id')
            ->where('etablissement_section.section_id', $sectionId)
            ->where('etablissement_section.etablissement_id', $etablissementId)
            ->where('emplois.classe_annee_id', $classe)
            ->select('emplois.*')
            ->get();
    }

    public static function getEmploiwhitClasse($section, $classe, $emploiId = null)
    {
        if ($emploiId === null) {
            $latestEmploi = Emploi::where('classe_annee_id', $classe)
                ->latest()
                ->first();
    
            if (!$latestEmploi) {
                return [];
            }
    
            $emploiId = $latestEmploi->id;
        }
        if($section == 1 || $section == 2){
            $seances = Seance::join('enseignement_annees', 'seances.niveau_matiere_id', '=', 'enseignement_annees.niveau_matiere_id')
            ->join('enseignants', 'enseignement_annees.enseignant_id', '=', 'enseignants.id')
            ->join('emplois', 'seances.emploi_id', '=', 'emplois.id')
            ->where('enseignement_annees.classe_annee_id', $classe)
            ->where('emplois.id', $emploiId)
            ->select('seances.*', 'enseignants.nom AS enseignant_nom', 'enseignants.prenom AS enseignant_prenom', 'emplois.date_debut', 'emplois.date_fin')
            ->get();
        } elseif($section == 3 || $section == 4){
            $seances = Seance::join('enseignement_annees', 'seances.filiere_niveau_matiere_ue_id', '=', 'enseignement_annees.filiere_niveau_matiere_ue_id')
            ->join('enseignants', 'enseignement_annees.enseignant_id', '=', 'enseignants.id')
            ->join('emplois', 'seances.emploi_id', '=', 'emplois.id')
            ->where('enseignement_annees.classe_annee_id', $classe)
            ->where('emplois.id', $emploiId)
            ->select('seances.*', 'enseignants.nom AS enseignant_nom', 'enseignants.prenom AS enseignant_prenom',  'emplois.date_debut', 'emplois.date_fin')
            ->get();
        }
        return $seances;
    }
}
