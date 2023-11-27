<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\HistoriqueBulletin;
use App\Models\HistoriqueNote;
use Illuminate\Support\Facades\DB;

if (!function_exists('calculerResultatsClasseSuperieure')) {
    function calculerResultatsClasseSuperieure($classeId, $section, $periode) {
        $resultatsClasse = [];
        $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $resultatMoyenne = calculerMoyenneSuperierure($classeId, $apprenant->id, $section, $periode);
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
        $moyenneClasse = calculerMoyenneClasse($resultatsClasse);

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

if (!function_exists('calculerMoyenneClasse')) {
    function calculerMoyenneClasse($resultatsClasse) {
        $totalMoyenneGenerale = 0;
        $nombreApprenants = count($resultatsClasse);

        foreach ($resultatsClasse as $resultat) {
            $totalMoyenneGenerale += $resultat['moyenne'];
        }

        // Éviter une division par zéro
        $moyenneClasse = ($nombreApprenants > 0) ? ($totalMoyenneGenerale / $nombreApprenants) : 0;

        return $moyenneClasse;
    }
}


if (!function_exists('ajouterHistoriqueBulletin')) {
    function ajouterHistoriqueBulletin($resultat) {
        $historiqueBulletin = HistoriqueBulletin::create([
            'apprenant_id' => $resultat['apprenant'],
            'nom_classe' => $resultat['nom_classe'],
            'periode' => $resultat['periode'],
            'classe_annee_id' => $resultat['classe'],
            'matricule_apprenant' => $resultat['matricule_apprenant'],
            'nom_prenom_apprenant' => $resultat['nom_apprenant'] . ' ' . $resultat['prenom_apprenant'],
            'moyenne_details_notes' => $resultat['moyenne'],
            'total_coefficient' => $resultat['total_coefficient'],
            'somme_note_generale' => $resultat['somme_note_generale'],
            'somme_note_generale_coefficient' => $resultat['somme_note_generale_coefficient'],
            'total_volume_horaire' => $resultat['total_volume_horaire'],
            'rang' => $resultat['rang'],
        ]);

        foreach ($resultat['details_notes'] as $detailNote) {
            HistoriqueNote::create([
                'historique_bulletin_id' => $historiqueBulletin->id,
                'nom_eu' => $detailNote['nom_eu'],
                'nom_matiere' => $detailNote['nom_matiere'],
                'coefficient' => $detailNote['coefficient_matiere'],
                'volume_horaire_matiere' => $detailNote['volume_horaire_matiere'],
                'note_origine_devoir' => $detailNote['note_origine_devoir'],
                'note_origine_examen' => $detailNote['note_origine_examen'],
                'note_devoir_pourcentage' => $detailNote['note_devoir'],
                'note_examen_pourcentage' => $detailNote['note_examen'],
                'note_generale' => $detailNote['note_generale'],
                'note_generale_coefficiente' => $detailNote['note_generale_coefficiente'],
            ]);
        }
    }
}