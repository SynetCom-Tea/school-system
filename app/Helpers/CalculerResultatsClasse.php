<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Classe;
use App\Models\ClasseAnnee;
use Illuminate\Support\Facades\DB;

if (!function_exists('calculerResultatsClasse')) {
    function calculerResultatsClasse($classeId) {
        $resultatsClasse = [];
        $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        dd($apprenantsDeLaClasse);
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $details_notes = calculerMoyenneSecondaire($classeId, $apprenant->id);
    
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
