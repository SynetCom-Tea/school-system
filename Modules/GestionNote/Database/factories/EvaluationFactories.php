<?php

use Modules\GestionNote\Entities\Evaluation;
function getDetailEvaluation(){
    $evaluations = DB::select("
        SELECT ev.id,p.libelle,en.nom,ev.date,t.libelle type
        FROM evaluations ev
        JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
        JOIN enseignants en ON en.id = ea.enseignant_id
        JOIN classe_annees ca ON ca.id = ea.classe_annee_id
        JOIN classes c ON c.id = ca.classe_id
        JOIN etablissement_section es ON es.id = c.etablissement_section_id
        JOIN etablissements e ON e.id = es.etablissement_id
        JOIN type_evaluations t ON t.id = ev.type_evaluation_id
        JOIN periodes p ON p.id = ev.periode_id
        WHERE e.id = :etablissement_id
        ",[
            'etablissement_id' => Auth::user()->etablissement_id
        ]);
    return $evaluations;
}