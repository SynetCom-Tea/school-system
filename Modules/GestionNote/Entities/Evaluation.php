<?php

namespace Modules\GestionNote\Entities;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\GestionNote\Entities\Evaluation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Enseignement\Entities\EnseignementAnnee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['session','date','notation', 'pourcentage', 'statut', 'periode_id', 'type_evaluation_id','enseignement_annee_id'];


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
    
    public static function getDetailEvaluationInferiere($etablissement_id,$evaluation_id){
        $evaluations = Evaluation::join('enseignement_annees','evaluations.enseignement_annee_id','=','enseignement_annees.id')
                                ->join('enseignants','enseignement_annees.enseignant_id','=','enseignants.id')
                                ->join('classe_annees','enseignement_annees.classe_annee_id','=','classe_annees.id')
                                ->join('classes','classe_annees.classe_id','=','classes.id')
                                ->join('etablissement_section','classes.etablissement_section_id','=','etablissement_section.id')
                                ->join('niveau_matieres','enseignement_annees.niveau_matiere_id','=','niveau_matieres.id')
                                ->join('matieres','niveau_matieres.matiere_id','=','matieres.id')
                                ->where('etablissement_section.etablissement_id',$etablissement_id)
                                ->where('evaluations.id',$evaluation_id)
                                ->select('matieres.nom');
        return $evaluations;
    }

    public static function getDetailEvaluationSuperieur($etablissement_id,$evaluation_id){
        $evaluations = Evaluation::join('enseignement_annees','evaluations.enseignement_annee_id','=','enseignement_annees.id')
                                ->join('enseignants','enseignement_annees.enseignant_id','=','enseignants.id')
                                ->join('classe_annees','enseignement_annees.classe_annee_id','=','classe_annees.id')
                                ->join('classes','classe_annees.classe_id','=','classes.id')
                                ->join('etablissement_section','classes.etablissement_section_id','=','etablissement_section.id')
                                ->join('niveau_matieres','enseignement_annees.niveau_matiere_id','=','niveau_matieres.id')
                                ->join('filiere_matiere_ues','niveau_matieres.filiere_matiere_ue_id','=','filiere_matiere_ues.id')
                                ->join('matieres','filiere_matiere_ues.matiere_id','=','matieres.id')
                                ->where('evaluations.id',$evaluation_id)
                                ->where('etablissement_section.etablissement_id',$etablissement_id)
                                ->select('matieres.nom');
        return $evaluations;
    }
}
