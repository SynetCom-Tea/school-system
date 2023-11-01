<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use Illuminate\Support\Facades\DB;

if (!function_exists('getNoteByClasses')) {
    function getNoteByClasses($classe, $apprenant = null) {
        $query = "
            SELECT 
                type_evaluations.libelle AS type_evaluation,
                periodes.libelle AS periode,
                notes.id AS note_id,
                notes.note,
                notes.date,
                apprenants.nom AS nom_apprenant,
                apprenants.prenom AS prenom_apprenant,
                apprenants.id AS id_apprenant,
                matieres.nom AS nom_matiere,
                niveau_matieres.coefficient AS coefficient_matiere
            FROM notes
            JOIN evaluations ON notes.evaluation_id = evaluations.id
            JOIN type_evaluations ON evaluations.type_evaluation_id = type_evaluations.id
            JOIN periodes ON evaluations.periode_id = periodes.id
            JOIN enseignement_annees ON evaluations.enseignement_annee_id = enseignement_annees.id
            JOIN niveau_matieres ON niveau_matieres.id = enseignement_annees.niveau_matiere_id
            JOIN apprenants ON notes.apprenant_id = apprenants.id
            JOIN matieres ON niveau_matieres.matiere_id = matieres.id
            WHERE classe_annee_id = :classe_annee_id";

        $parameters = ['classe_annee_id' => $classe];

        if ($apprenant !== null) {
            $query .= " AND apprenants.id = :apprenant_id";
            $parameters['apprenant_id'] = $apprenant;
        }

        $notes = DB::select($query, $parameters);

        return $notes;
    }
}
