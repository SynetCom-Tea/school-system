<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Absence;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Emploi\Entities\Emploi;

if (!function_exists('getNoteTuteurChildren')) {
    function getNoteTuteurChildren($childrenID) {
        $query = DB::table('notes')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('type_evaluations', 'evaluations.type_evaluation_id', '=', 'type_evaluations.id')
            ->join('periodes', 'evaluations.periode_id', '=', 'periodes.id')
            ->join('enseignement_annees', 'evaluations.enseignement_annee_id', '=', 'enseignement_annees.id')
            ->join('apprenants', 'notes.apprenant_id', '=', 'apprenants.id')
            ->whereIn('apprenants.id', $childrenID)
            ->where('notes.statut', 1);
        $query->join('niveau_matieres', 'enseignement_annees.niveau_matiere_id', '=', 'niveau_matieres.id')
            ->join('matieres', 'niveau_matieres.matiere_id', '=', 'matieres.id')
            ->select(
                'type_evaluations.libelle AS type_evaluation',
                'periodes.libelle AS periode',
                'notes.id AS note_id',
                'notes.note',
                'notes.date',
                'apprenants.id AS id_apprenant',
                'apprenants.matricule AS matricule_apprenant',
                'apprenants.nom AS nom_apprenant',
                'apprenants.prenom AS prenom_apprenant',
                'matieres.id AS id_matiere',
                'matieres.nom AS nom_matiere',
                'niveau_matieres.coefficient AS coefficient_matiere',
                'niveau_matieres.notation AS notation_matiere'
            );
        $query->groupBy('apprenants.id', 'evaluations.id');
        $results = $query->get();
        // Traitement des résultats pour obtenir la structure souhaitée
        $resultatsQuery = [];
        foreach ($results as $result) {
            $apprenant = [
                'id_apprenant' => $result->id_apprenant,
                'matricule' => $result->matricule_apprenant,
                'nom' => $result->nom_apprenant,
                'prenom' => $result->prenom_apprenant,
            ];

            $evaluationInfo = [
                'id_evaluation' => $result->note_id,
                'periode_evaluation' => $result->periode,
                'date_evaluation' => $result->date,
                'type_evaluation' => $result->type_evaluation,
                'note_obtenue' => $result->note,
                'matiere' => [
                    'id_matiere' => $result->id_matiere,
                    'nom_matiere' => $result->nom_matiere,
                    'coefficient_matiere' => $result->coefficient_matiere,
                    'notation_matiere' => $result->notation_matiere,
                ],
            ];

            if (!isset($resultatsQuery[$result->id_apprenant])) {
                $resultatsQuery[$result->id_apprenant] = [
                    'apprenant' => $apprenant,
                    'evaluations' => [],
                ];
            }

            $resultatsQuery[$result->id_apprenant]['evaluations'][] = $evaluationInfo;
        }
        // Convertir le tableau associatif en une simple liste pour obtenir le résultat final
        $resultatsFinauxQuery = array_values($resultatsQuery);
        return $resultatsFinauxQuery;
    }
}

if (!function_exists('getAbsenceOfTuteurChildren')) {
    function getAbsenceOfTuteurChildren($childrenID) {
        $absencesUneSeance = Absence::with('apprenant')->whereNotNull('seance_id')->whereIn('apprenant_id', $childrenID)->get();
        $absencesJourneeEntiere = Absence::with('apprenant')->whereNull('seance_id')->whereIn('apprenant_id', $childrenID)->get();
        $seances = Emploi::getSeancesByIds($absencesUneSeance->pluck('seance_id'));
        $seancesById = collect($seances)->keyBy('id');
        $absencesJourneeEntiereAll = collect($absencesJourneeEntiere)->map(function ($absence) {
            $absenceData = [
                'id' => $absence['id'],
                'date' => Carbon::parse($absence['date'])->locale('fr_FR')->isoFormat('dddd D MMMM YYYY'),
                'journee' => $absence['journee'],
                'nom_complet' => $absence['apprenant']['matricule'] . ' - ' . $absence['apprenant']['nom'] . '  ' .$absence['apprenant']['prenom'],
                'jour' => null,
                'nom_matiere_heure_debut' => null,
                'nom_prenom_enseignant' => null,
                // Ajoutez d'autres champs de Absence que vous souhaitez inclure
            ];
            return $absenceData;
        });
        // Parcourir les absencesUneSeance et ajouter les informations de la séance correspondante
        $absencesJourneeAll = collect($absencesUneSeance)->map(function ($absence) use ($seancesById) {
            if ($absence['seance_id'] !== null) {
                $seance = $seancesById->get($absence['seance_id']);
                // Sélectionner spécifiquement quelques informations de Seance
                $heureDebutSansSecondes = Carbon::parse($seance['heure_debut'])->format('H:i');
                $heureFinSansSecondes = Carbon::parse($seance['heure_fin'])->format('H:i');
                $seanceData = [
                    'jour' => $seance['jour'],
                    'nom_matiere_heure_debut' => $seance['nom_matiere'] . ' - ' . $heureDebutSansSecondes . ' à ' . $heureFinSansSecondes,
                    'nom_prenom_enseignant' => $seance['enseignant_nom'] . ' - ' . $seance['enseignant_prenom'],
                    // Ajoutez d'autres champs de Seance que vous souhaitez inclure
                ];
            
                // Sélectionner spécifiquement quelques informations de Absence
                $absenceData = [
                    'id' => $absence['id'],
                    'date' => Carbon::parse($absence['date'])->locale('fr_FR')->isoFormat('dddd D MMMM YYYY'),
                    'journee' => $absence['journee'],
                    'nom_complet' => $absence['apprenant']['matricule'] . ' - ' . $absence['apprenant']['nom'] . '  ' .$absence['apprenant']['prenom'],
                    // Ajoutez d'autres champs de Absence que vous souhaitez inclure
                ];
            
                // Fusionner les informations sélectionnées de Seance avec Absence
                return array_merge($absenceData, $seanceData);
            }
            
        });
        return array_merge($absencesJourneeEntiereAll->toArray(), $absencesJourneeAll->toArray());
    }
}