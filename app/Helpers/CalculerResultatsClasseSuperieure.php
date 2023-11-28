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
use Modules\GestionNote\Entities\Periode;

if (!function_exists('calculerResultatsClasseSuperieure')) {
    function calculerResultatsClasseSuperieure($classeId, $section, $periode) {
        $resultatsClasse = [];
        $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $resultatMoyenne = calculerMoyenneSuperierure($classeId, $apprenant->id, $section, $periode);
            $resultatsClasse[$apprenant->id] = [
                'classe_annee_id' => $classeId,
                'periode' => $resultatMoyenne['periode'],
                'nom_classe' => Classe::find($classeId)->libelle,
                'apprenant_id' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_prenom_apprenant' => $apprenant->nom . ' ' . $apprenant->prenom,
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
    function createHistoriqueBulletin($resultat, $section)
    {
        $commonFields = [
            'apprenant_id' => $resultat['apprenant_id'],
            'nom_classe' => $resultat['nom_classe'],
            'periode' => $resultat['periode'],
            'classe_annee_id' => $resultat['classe_annee_id'],
            'matricule_apprenant' => $resultat['matricule_apprenant'],
            'nom_prenom_apprenant' => $resultat['nom_prenom_apprenant'],
        ];

        switch ($section) {
            case 1:
                $commonFields += [
                    'moyenne_details_notes' => $resultat['moyenne_details_notes'],
                    'somme_notation' => $resultat['somme_notation'],
                    'somme_note_generale' => $resultat['somme_note_generale'],
                ];
                break;
            case 2:
                $commonFields += [
                    'moyenne_details_notes' => $resultat['moyenne_details_notes'],
                ];
                break;
            case 3:
                $commonFields += [
                    'moyenne_details_notes' => $resultat['moyenne_details_notes'],
                    'total_coefficient' => $resultat['total_coefficient'],
                    'somme_note_generale' => $resultat['somme_note_generale'],
                    'somme_note_generale_coefficient' => $resultat['somme_note_generale_coefficient'],
                    'total_volume_horaire' => $resultat['total_volume_horaire'],
                ];
                break;
            default:
                // Handle invalid section
                return;
        }

        $historiqueBulletin = HistoriqueBulletin::create($commonFields);

        foreach ($resultat['details_notes'] as $detailNote) {
            createHistoriqueNote($historiqueBulletin->id, $detailNote, $section);
        }
    }

    function createHistoriqueNote($historiqueBulletinId, $detailNote, $section)
    {
        $commonFields = [
            'historique_bulletin_id' => $historiqueBulletinId,
            'nom_matiere' => $detailNote['nom_matiere'],
            // Add other common fields here
        ];

        switch ($section) {
            case 1:
                $commonFields += [
                    'notation_matiere' => $detailNote['notation_matiere'],
                    'note' => $detailNote['note'],
                ];
                break;
            case 2:
                    $commonFields += [
                        'coefficient' => $detailNote['coefficient'],
                        'note_de_classe' => $detailNote['noteDeClasse'],
                        // Add other fields for section 2
                    ];
                    break;
            case 3:
                $commonFields += [
                    'coefficient' => $detailNote['coefficient_matiere'],
                    'volume_horaire_matiere' => $detailNote['volume_horaire_matiere'],
                    // Add other fields for section 3
                ];
                break;
            default:
                // Handle invalid section
                return;
        }

        HistoriqueNote::create($commonFields);
    }

    function ajouterHistoriqueBulletin($resultat, $section, $exception = null)
    {
        if ($section == 1) {
            if ($exception != null) {
                $checkhistorique = HistoriqueBulletin::where('classe_annee_id', $resultat['classe_annee_id'])
                ->where('periode', $resultat['periode'])
                ->where('apprenant_id', $resultat['apprenant_id'])
                ->where('statut', true)
                ->latest()
                ->first();
                if ($checkhistorique != null) {
                    $communs = array_intersect_assoc($checkhistorique->toArray(), $resultat);
                    if (empty(array_diff(['apprenant_id', 'classe_annee_id', 'periode', 'matricule_apprenant', 'nom_prenom_apprenant', 'nom_classe', 'moyenne_details_notes', 'somme_notation', 'somme_note_generale'], array_keys($communs)))) {
                        return;
                    } else {
                        createHistoriqueBulletin($resultat, $section);
                        $checkhistorique->update(['statut' => false]);
                    }
                } else {
                    createHistoriqueBulletin($resultat, $section);
                    return;
                }
            } else {
                createHistoriqueBulletin($resultat, $section);
            }
        } elseif ($section == 2) {
            if ($exception != null) {
                // Handle exception for section 2 if needed
            } else {
                createHistoriqueBulletin($resultat, $section);
            }
        } elseif ($section == 3) {
            if ($exception != null) {
                // Handle exception for section 3 if needed
            } else {
                createHistoriqueBulletin($resultat, $section);
            }
        }
        
    }
}
