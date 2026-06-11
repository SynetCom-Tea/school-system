<?php


/**
 * Write code on Method
 *
 * @return response()
 */


 if (!function_exists('calculerMoyenneSecondaire')) {
    function calculerMoyenneSecondaire($classeID, $section, $periode, $apprenantID) {
        $notes_apprenant = getNoteByClasses($classeID, $section, $periode, $apprenantID);
        $notestypeComposition = collect($notes_apprenant)->where('type_evaluation', 'Composition');
        $notesDeClasses = collect($notes_apprenant)->whereIn('type_evaluation', ['Interrogation', 'Devoir Surveillé', 'Devoir', 'Devoir / Devoir Surveillé', 'Examen']);
        $groupedNotes = $notesDeClasses->groupBy('nom_matiere'); 
        // dd($notes_apprenant);
        $details_notes = [];
        foreach ($groupedNotes as $matiere => $notes) {
            // dd($notes);
            $compositionNotes = $notestypeComposition->where('nom_matiere', $matiere);
            
            // Calculate total notes and average note
            $totalNotes = $notes->sum('note');
            $averageNote = $notes->avg('note');
            
            // Calculate 'noteDeClasse' or set it to 0 if null
            $noteDeClasse = $averageNote !== null ? $averageNote : 0;
            $noteDeComposition = $compositionNotes->sum('note');
            $coefficient = $notes->first()->coefficient_matiere;

          
            $noteDeClasseCoefficiente = $noteDeClasse * $coefficient;
            $noteDeCompositionCoefficiente = $noteDeComposition * $coefficient;

            $moyenne = round(($noteDeClasse + $noteDeComposition) / 2, 2);
            // $moyenneCoefficiente = ($noteDeClasseCoefficiente + $noteDeCompositionCoefficiente) / 2;
            $moyenneCoefficiente = $moyenne * $coefficient;
            $details_notes[] = [
                'nom_matiere' => $matiere,
                'type_matiere' => $compositionNotes->first() ? $compositionNotes->first()->type_matiere : $notes->first()->type_matiere,
                'periodes' => $notes->first()->periode,
                'coefficient' => $coefficient,
                'note_de_classe' => $noteDeClasse,
                'note_de_classe_coefficiente' => $noteDeClasseCoefficiente,
                'note_de_composition' => $noteDeComposition,
                'note_de_composition_coefficiente' => $noteDeCompositionCoefficiente,
                'moyenne' => $moyenne,
                'moyenne_coefficiente' => $moyenneCoefficiente
            ];
        }
        if(count($details_notes) != 0){
            $details_notes[] = [
                'nom_matiere' => 'Conduite',
                'type_matiere' => 'Autre',
                'coefficient' => 1,
                'note_de_classe' => 18,
                'note_de_classe_coefficiente' => 18,
                'note_de_composition' => 18,
                'note_de_composition_coefficiente' => 18,
                'moyenne' => 18,
                'moyenne_coefficiente' => 18
            ];
        }
        // dd('details_notes', $details_notes);
        return $details_notes;
    }
}



if (!function_exists('calculateMoyenneGeneralSecondaire')) {
    function calculateMoyenneGeneralSecondaire($detailsNotes) {
        $totalMoyenne = 0;
        $totalCoefficient = 0;
        foreach ($detailsNotes as $details) {
            $totalMoyenne += $details['moyenne'] * $details['coefficient'];
            $totalCoefficient += $details['coefficient'];
        }
        $averageMoyenneDetailsNotes = $totalCoefficient > 0 ? number_format($totalMoyenne / $totalCoefficient, 2) : 0;
        
        return $averageMoyenneDetailsNotes;
    }
}   

if (!function_exists('ordinalSuffix')) {
    function ordinalSuffix($num) {
        if ($num % 10 === 1 && $num % 100 !== 11) {
            return $num . 'er';
        } elseif ($num % 10 === 2 && $num % 100 !== 12) {
            return $num . 'ème';
        } elseif ($num % 10 === 3 && $num % 100 !== 13) {
            return $num . 'ème';
        }
        return $num . 'ème';
    }
}

// ================ fonction de conversion de la moyenne en lettre ==================

if (!function_exists('moyenneEnLettre')) {
    function moyenneEnLettre($moyenne)
    {
        if ($moyenne === null) {
            return '';
        }

        $moyenne = round($moyenne, 2);

        $formatter = new NumberFormatter('fr_FR', NumberFormatter::SPELLOUT);

        $entier = floor($moyenne);
        $decimal = round(($moyenne - $entier) * 100);

        if ($decimal > 0) {
            return ucfirst(
                $formatter->format($entier)
                . ' virgule '
                . $formatter->format($decimal)
            );
        }

        return ucfirst($formatter->format($entier));
    }
}
