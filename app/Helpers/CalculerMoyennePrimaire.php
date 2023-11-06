<?php


/**
 * Write code on Method
 *
 * @return response()
 */


 if (!function_exists('calculerMoyennePrimaire')) {
    function calculerMoyennePrimaire($notes_apprenant) {
        // dd($notes_apprenant);
        $somme_notes = 0;
        $somme_notations = 0;
    
        // Calcul de la somme des notes et de la somme des notations de matière
        foreach ($notes_apprenant as $note) {
            $somme_notes += $note->note;
            $somme_notations += $note->notation_matiere; // Assurez-vous que le champ pour la notation de matière est 'notation_matiere'
        }

        if ($somme_notations !== 0) {
            $somme_notations = intval($somme_notations / 10);
            // Calcul du moyenne des notes par la somme des notations de matière
            $moyenne = $somme_notes / $somme_notations;
            $moyenne_formate = number_format($moyenne, 2);
            return $moyenne_formate;
        } else {
            return 0;
        }
    }
}