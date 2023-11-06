<?php


/**
 * Write code on Method
 *
 * @return response()
 */

 if (!function_exists('sss')) {
    function sss($notes_reforme, $apprenant) {
        $reformFinalEssaie = collect($notes_reforme)->where('id_apprenant', $apprenant)->groupBy('nom_matiere')->map(function ($item) {
            $matiere = $item->first()->nom_matiere;
        
            $result = [
                'nom_matiere' => $matiere,
                'note_Composition' => 0,
                'noteCoefficient_Composition' => 0,
                'note_Interrogation' => 0,
                'noteCoefficient_Interrogation' => 0,
                'note_Devoir_Surveillé' => 0,
                'noteCoefficient_Devoir_Surveillé' => 0,
            ];
        
            foreach ($item as $note) {
                $type = str_replace(' ', '_', $note->type_evaluation);
                $result['note_' . $type] += $note->note;
                $result['noteCoefficient_' . $type] += $note->note * $note->coefficient_matiere;
            }
        
            // Regroupement des types d'évaluation Interrogation et Devoir Surveillé sous Devoir
            $result['note_Devoir'] = ($result['note_Interrogation'] + $result['note_Devoir_Surveillé']) / 2;
            $result['noteCoefficient_Devoir'] = ($result['noteCoefficient_Interrogation'] + $result['noteCoefficient_Devoir_Surveillé']) / 2;
        
            unset($result['note_Interrogation'], $result['noteCoefficient_Interrogation'], $result['note_Devoir_Surveillé'], $result['noteCoefficient_Devoir_Surveillé']);
        
            return $result;
        })->values();
        $notesAvecCoefficientsParType = collect($notes_reforme)->where('id_apprenant', $apprenant)->groupBy('nom_matiere')->map(function ($item) {
            $matiere = $item->first()->nom_matiere;
        
            $result = [
                'nom_matiere' => $matiere,
            ];
        
            // Création des clés vides pour chaque type d'évaluation
            $typesEvaluation = $item->pluck('type_evaluation')->unique();
            foreach ($typesEvaluation as $type) {
                $result['note_' . str_replace(' ', '_', $type)] = null;
                $result['noteCoefficient_' . str_replace(' ', '_', $type)] = null;
            }
        
            // Remplissage des données
            foreach ($item as $note) {
                $type = $note->type_evaluation;
                $result['note_' . str_replace(' ', '_', $type)] = $note->note;
                $result['noteCoefficient_' . str_replace(' ', '_', $type)] = $note->note * $note->coefficient_matiere;
            }
        
            return $result;
        })->values();

        return $reformFinalEssaie;
    }
}