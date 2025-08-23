<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\RegimeEvaluation;
use Illuminate\Support\Facades\DB;
use App\Models\EtablissementSection;
use Illuminate\Support\Facades\Auth;

 if (!function_exists('calculerMoyenneSuperierure')) {
    function calculerMoyenneSuperierure($classeID, $apprenantID, $section, $periode,$session = null) {
        // $session = true;
        $notes_apprenant = getNoteByClasses($classeID, $section, $periode, $apprenantID,$session);
        // dd($notes_apprenant);
        $groupedNotes = collect($notes_apprenant)->groupBy('nom_matiere');
        $details_notes = [];
        $periode = null;
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id,  $section);
        $systeme_lmd_id = DB::table('etablissement_section')
        ->find($etablissement_section[0], ['etablissement_section.systeme_lmd_id']);
        $regime_evaluation = RegimeEvaluation::with('type_evaluation')
        ->where('systeme_lmd_id', $systeme_lmd_id->systeme_lmd_id)->get();
        // dd($systeme_lmd_id, $regime_evaluation);
        foreach ($groupedNotes as $matiere => $notes) {
            // dd($notes, $groupedNotes);
            $note_devoir = 0;
            $note_examen = 0;
            $note_autre = 0;
            if($systeme_lmd_id->systeme_lmd_id == 1){
                foreach ($notes as $element) {
                    // dump($element);
                    // Stocker les notes d'origine
                    if ($session == null){
                        if ($element->type_evaluation === 'Devoir') {
                            $note_origine_devoir = $element->note;
                            $note_devoir += $note_origine_devoir * 0.3; // Accumuler les notes de devoir
                        } elseif ($element->type_evaluation === 'Examen') {
                            $note_origine_examen = $element->note;
                            $note_examen += $note_origine_examen * 0.7; // Accumuler les notes d'examen
                        }
                    }else {
                        if ($element->type_evaluation === 'Examen'){
                            $note_examen += $element->note;
                        }
                    }
                }
            }elseif($etablissement_section == 2){
                foreach ($notes as $element) {
                    // Stocker les notes d'origine
                    if ($element->type_evaluation === 'Devoir') {
                        $note_origine_devoir = $element->note;
                        $note_devoir += $note_origine_devoir * 0.8; // Accumuler les notes de devoir
                    } elseif ($element->type_evaluation === 'Autre') {
                        $note_origine_autre = $element->note;
                        $note_autre += $note_origine_autre * 0.2; // Accumuler les notes d'autre
                    }
                }
            }
            
            // Calcul de la note générale pour la matière
            if ($session == null){
                $note_generale = $note_devoir + $note_examen;
            }else {
                $note_generale =  $note_examen;
            }
            // Calcul de la note générale pondérée par le coefficient
            // dump($note_generale);
            $note_generale_coefficiente = $note_generale * $notes[0]->coefficient_matiere;

            $details_notes[] = [
                'nom_eu' => $notes[0]->nom_ue,
                'nom_matiere' => $matiere,
                'id_ue' => $notes[0]->id_ue,
                'id_matiere' => $notes[0]->id_matiere,
                'note_origine_devoir' => $note_origine_devoir ?? null,
                'note_origine_examen' => $note_origine_examen ?? null,
                'note_devoir_pourcentage' => $note_devoir,
                'note_examen_pourcentage' => $note_examen,
                'coefficient_matiere' => $notes[0]->coefficient_matiere,
                'volume_horaire_matiere' => $notes[0]->volume_horaire_matiere,
                'note_generale' => $note_generale,
                'note_generale_coefficiente' => $note_generale_coefficiente,
            ];
            $periode = $notes[0]->periode;
            // dd($details_notes);
        }
        // die();
        $moyennes = calculerMoyenneGenerale($details_notes);

        $resultats = [
            'details_notes' => $details_notes,
            'periode' => $periode,
            'total_volume_horaire' => $moyennes['total_volume_horaire'],
            'total_coefficient' => $moyennes['total_coefficient'],
            'credit'=>$moyennes['credit'],
            'somme_note_generale' => $moyennes['somme_note_generale'],
            'somme_note_generale_coefficient' => $moyennes['somme_note_generale_coefficient'],
            'moyenne_generale' => $moyennes['moyenne_generale']
        ];
        return $resultats;
    }   
}

if (!function_exists('calculerMoyenneGeneraleSup')) {
    function calculerMoyenneGenerale($details_notes) {
        $totalCoefficient = 0;
        $totalVolumeHoraire = 0;
        $sommeNoteGenerale = 0;
        $sommeNoteGeneraleCoefficient = 0;
        $credit = 0;


        foreach ($details_notes as $details) {
            $coefficient_matiere = $details['coefficient_matiere'];
            $note_generale = $details['note_generale'];
            $note_generale_coefficiente = $details['note_generale_coefficiente'];
            $volume_horaire_matiere = $details['volume_horaire_matiere'];

            $totalCoefficient += $coefficient_matiere;
            $sommeNoteGenerale += $note_generale;
            $sommeNoteGeneraleCoefficient += $note_generale_coefficiente;
            $totalVolumeHoraire += $volume_horaire_matiere;
            if($note_generale>=10){
                $credit += $coefficient_matiere;
            }
        }

        // Éviter une division par zéro
        $moyenne_generale = ($totalCoefficient > 0) ? number_format(($sommeNoteGeneraleCoefficient / $totalCoefficient), 2) : 0;
        $moyennes = [
            'total_volume_horaire' => $totalVolumeHoraire,
            'total_coefficient' => $totalCoefficient,
            'somme_note_generale' => $sommeNoteGenerale,
            'somme_note_generale_coefficient' => $sommeNoteGeneraleCoefficient,
            'moyenne_generale' => $moyenne_generale,
            'credit'=>$credit,
        ];
        // dd($totalCoefficient, $sommeNoteGeneraleCoefficient);
        return $moyennes;
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