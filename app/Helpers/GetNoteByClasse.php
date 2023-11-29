<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use Illuminate\Support\Facades\DB;

if (!function_exists('getNoteByClasses')) {
    function getNoteByClasses($classe, $section, $periode, $apprenant = null) {
        $query = DB::table('notes')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('type_evaluations', 'evaluations.type_evaluation_id', '=', 'type_evaluations.id')
            ->join('periodes', 'evaluations.periode_id', '=', 'periodes.id')
            ->join('enseignement_annees', 'evaluations.enseignement_annee_id', '=', 'enseignement_annees.id')
            ->join('apprenants', 'notes.apprenant_id', '=', 'apprenants.id')
            ->where('classe_annee_id', $classe)
            ->where('evaluations.periode_id', $periode)
            ->where('notes.statut', 1);
        if ($section == 1) {
            $query->where('type_evaluations.libelle', 'Composition');
        }
        if ($apprenant !== null) {
            $query->where('apprenants.id', $apprenant);
        }

        if ($section == 1 || $section == 2) {
            $query->join('niveau_matieres', 'enseignement_annees.niveau_matiere_id', '=', 'niveau_matieres.id')
                ->join('matieres', 'niveau_matieres.matiere_id', '=', 'matieres.id')
                ->select(
                    'type_evaluations.libelle AS type_evaluation',
                    'periodes.libelle AS periode',
                    'notes.id AS note_id',
                    'notes.note',
                    'notes.date',
                    'apprenants.nom AS nom_apprenant',
                    'apprenants.prenom AS prenom_apprenant',
                    'apprenants.id AS id_apprenant',
                    'matieres.id AS id_matiere',
                    'matieres.nom AS nom_matiere',
                    'niveau_matieres.coefficient AS coefficient_matiere',
                    'niveau_matieres.notation AS notation_matiere'
                );
        } elseif ($section == 3) {
            $query->join('filiere_niveau_matiere_ues', 'enseignement_annees.filiere_niveau_matiere_ue_id', '=', 'filiere_niveau_matiere_ues.id')
                ->join('matieres', 'filiere_niveau_matiere_ues.matiere_id', '=', 'matieres.id')
                ->join('ues', 'filiere_niveau_matiere_ues.ue_id', '=', 'ues.id')
                ->select(
                    'type_evaluations.libelle AS type_evaluation',
                    'periodes.libelle AS periode',   
                    'notes.id AS note_id',
                    'notes.note',
                    'notes.date',
                    'apprenants.nom AS nom_apprenant',
                    'apprenants.prenom AS prenom_apprenant',
                    'apprenants.id AS id_apprenant',
                    'matieres.id AS id_matiere',
                    'ues.id AS id_ue',
                    'matieres.nom AS nom_matiere',
                    'ues.libelle AS nom_ue',
                    'filiere_niveau_matiere_ues.coefficient AS coefficient_matiere',
                    'filiere_niveau_matiere_ues.volume_horaire AS volume_horaire_matiere'
                );
        }

        $notes = $query->get();

        return $notes;
    }
}
