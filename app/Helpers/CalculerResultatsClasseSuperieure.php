<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Classe;
use App\Models\ClasseAnnee;
use Illuminate\Support\Facades\DB;

if (!function_exists('calculerResultatsClasseSuperieure')) {
    function calculerResultatsClasseSuperieure($classeId, $section) {
        $resultatsClasse = [];
        $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $resultatMoyenne = calculerMoyenneSuperierure($classeId, $apprenant->id, $section);
            $resultatsClasse[$apprenant->id] = [
                'classe' => $classeId,
                'periode' => $resultatMoyenne['periode'],
                'nom_classe' => Classe::find($classeId)->libelle,
                'apprenant' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_apprenant' => $apprenant->nom,
                'prenom_apprenant' => $apprenant->prenom,
                'total_volume_horaire' => $resultatMoyenne['total_volume_horaire'],
                'total_coefficient' => $resultatMoyenne['total_coefficient'],
                'somme_note_generale' => $resultatMoyenne['somme_note_generale'],
                'somme_note_generale_coefficient' => $resultatMoyenne['somme_note_generale_coefficient'],
                'moyenne' => $resultatMoyenne['moyenne_generale'],
                'details_notes' => $resultatMoyenne['details_notes'], // Tableau des détails des notes
            ];
        }
        $resultatsClasseAvecRang = calculerRangApprenants($resultatsClasse);
        // dd($resultatsClasseAvecRang);
        return $resultatsClasseAvecRang;
    }
}


if (!function_exists('calculerRangApprenants')) {
    function calculerRangApprenants($resultatsClasse) {
        // Trier le tableau des résultats par la moyenne générale de chaque apprenant de manière décroissante
        usort($resultatsClasse, function ($a, $b) {
            return $b['moyenne'] <=> $a['moyenne'];
        });

        $rang = 1;
        $classement_precedent = null;

        foreach ($resultatsClasse as &$resultat) {
            if ($classement_precedent !== null && $resultat['moyenne'] < $classement_precedent) {
                $rang++;
            }
            $resultat['rang'] = $rang;
            $classement_precedent = $resultat['moyenne'];
        }

        return $resultatsClasse;
    }
}