<?php


/**
 * Write code on Method
 *
 * @return response()
 */


 if (!function_exists('calculerMoyenneSecondaire')) {
    function calculerMoyenneSecondaire($classeID, $apprenantID) {
        $notes_apprenant = getNoteByClasses($classeID, $apprenantID);
        $notestypeComposition = collect($notes_apprenant)->where('type_evaluation', 'Composition');
        $notesDeClasses = collect($notes_apprenant)->whereIn('type_evaluation', ['Interrogation', 'Devoir Surveillé', 'Devoir']);
        $groupedNotes = $notesDeClasses->groupBy('nom_matiere');
        $details_notes = [];
        foreach ($groupedNotes as $matiere => $notes) {
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

            $moyenne = ($noteDeClasse + $noteDeComposition) / 2;
            $moyenneCoefficiente = ($noteDeClasseCoefficiente + $noteDeCompositionCoefficiente) / 2;
            
            $details_notes[] = [
                'nom_matiere' => $matiere,
                'coefficient' => $coefficient,
                'noteDeClasse' => $noteDeClasse,
                'noteDeClasseCoefficiente' => $noteDeClasseCoefficiente,
                'noteDeComposition' => $noteDeComposition,
                'noteDeCompositionCoefficiente' => $noteDeCompositionCoefficiente,
                'moyenne' => $moyenne,
                'moyenneCoefficiente' => $moyenneCoefficiente
            ];
        }
        if(count($details_notes) != 0){
            $details_notes[] = [
                'nom_matiere' => 'Conduite',
                'coefficient' => 1,
                'noteDeClasse' => 18,
                'noteDeClasseCoefficiente' => 18,
                'noteDeComposition' => 18,
                'noteDeCompositionCoefficiente' => 18,
                'moyenne' => 18,
                'moyenneCoefficiente' => 18
            ];
        }
        return $details_notes;
    }
}

if (!function_exists('calculateMoyenneGeneralSecondaire')) {
    function calculateMoyenneGeneralSecondaire($detailsNotes) {
        $totalMoyenne = 0;
        foreach ($detailsNotes as $details) {
            $totalMoyenne += $details['moyenne'];
        }
        $averageMoyenneDetailsNotes = count($detailsNotes) > 0 ? number_format($totalMoyenne / count($detailsNotes), 2) : 0;
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