<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use Illuminate\Support\Facades\DB;

if (!function_exists('calculerResultatsClasse')) {
    function calculerResultatsClasse($classeId, $section, $periode) {
        $resultatsClasse = [];
        $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        //dd($apprenantsDeLaClasse);
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $details_notes = calculerMoyenneSecondaire($classeId, $section, $periode, $apprenant->id);
            $resultatsClasse[$apprenant->id] = [
                'classe' => $classeId,
                'periode' => $details_notes[0]['periodes'],
                'nom_classe' => Classe::find($classeId)->libelle,
                'apprenant' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_apprenant' => $apprenant->nom,
                'prenom_apprenant' => $apprenant->prenom,
                'details_notes' => $details_notes, // Tableau des détails des notes
            ];
        }

        // Transformer le tableau associatif en tableau indexé pour trier
        $resultatsClasse = array_values($resultatsClasse);

        foreach ($resultatsClasse as &$resultat) {
            $totalMoyenne = 0;

            foreach ($resultat['details_notes'] as $details) {
                $totalMoyenne += $details['moyenne'];
            }

            $resultat['moyenne_details_notes'] = count($resultat['details_notes']) > 0 ? number_format($totalMoyenne / count($resultat['details_notes']), 2) : 0;
        }

        usort($resultatsClasse, function ($a, $b) {
            return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
        });

        $rank = 1;
        $prevRank = 1;

        foreach ($resultatsClasse as &$resultat) {
            $resultat['rang'] = ($prevRank === $rank) ? '=' . $rank : $rank;
            $prevRank = $rank;
            $rank++;
        }

        return $resultatsClasse;
    }
}

if (!function_exists('calculerResultatsClassePrimaire')) {
    function calculerResultatsClassePrimaire($classeId, $section, $etablissement_section, $periode) {
        $resultatsClasse = [];
        $classe = getClasses(Annee::find(2)->id, $etablissement_section, $classeId)->firstOrFail();
        $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $notes_apprenant = getNoteByClasses($classeId, $section, $periode, $apprenant->id);
            //dd($notes_apprenant);
            $moyenne = calculerMoyennePrimaire(collect($notes_apprenant)->where('type_evaluation', 'Composition'));
        
            // Initialize $details_notes for each apprenant
            $details_notes = [];
        
            foreach ($notes_apprenant as $note) {
                $details_notes[] = [
                    'nom_matiere' => $note->nom_matiere,
                    'notation_matiere' => $note->notation_matiere,
                    'note' => $note->note
                ];
            }
        
            $resultatsClasse[] = [
                'classe' => $classeId,
                'periode' => $notes_apprenant[0]->periode,
                'nom_classe' => $classe->libelle,
                'apprenant' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_apprenant' => $apprenant->nom,
                'prenom_apprenant' => $apprenant->prenom,
                'moyenne' => $moyenne,
                'details_notes' => $details_notes // Tableau des détails des notes
            ];
        }
        // Transformer le tableau associatif en tableau indexé pour trier
        $resultatsClasse = array_values($resultatsClasse);

        usort($resultatsClasse, function ($a, $b) {
            return $b['moyenne'] <=> $a['moyenne'];
        });

        $rank = 1;
        $prevRank = 1;

        foreach ($resultatsClasse as &$resultat) {
            $resultat['rang'] = ($prevRank === $rank) ? '=' . $rank : $rank;
            $prevRank = $rank;
            $rank++;
        }
        return $resultatsClasse;
    }
}
