<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\HistoriqueNote;
use App\Models\HistoriqueBulletin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\GestionNote\Entities\Periode;

if (!function_exists('calculerResultatsClasseSuperieure')) {
    function calculerResultatsClasseSuperieure($classeId, $section, $etablissement_section, $periode, $apprenants = null, $session = null)
    {
        $resultatsClasse = [];
        $annee = Annee::where('actif', 1)->first();
        $classe = getClasses($annee->id, $etablissement_section, $classeId)->firstOrFail();
        // dd($classe);
        if ($apprenants != null) {
            $apprenantsDeLaClasse = $apprenants;
            // dd($apprenants);
        } else {
            $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
            // dd($apprenantsDeLaClasse);
        }
        // dd($apprenantsDeLaClasse);
        foreach ($apprenantsDeLaClasse as $key => $apprenant) {
            $resultatMoyenne = calculerMoyenneSuperierure($classeId, $apprenant->id, $section, $periode, $session);
            $resultatsClasse[$apprenant->id] = [
                'classe_annee_id' => $classeId,
                'periode' => $resultatMoyenne['periode'] ?? \App\Models\Periode::find($periode)->libelle,
                'nom_classe' => $classe->libelle,
                'apprenant_id' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_prenom_apprenant' => $apprenant->nom . ' ' . $apprenant->prenom,
                'total_volume_horaire' => $resultatMoyenne['total_volume_horaire'],
                'total_coefficient' => $resultatMoyenne['total_coefficient'],
                'somme_note_generale' => $resultatMoyenne['somme_note_generale'],
                'credit' => $resultatMoyenne['credit'],
                'somme_note_generale_coefficient' => $resultatMoyenne['somme_note_generale_coefficient'],
                'moyenne_details_notes' => $resultatMoyenne['moyenne_generale'],
                'details_notes' => $resultatMoyenne['details_notes'], // Tableau des détails des notes
            ];
            // dump($resultatsClasse);
        }
        // die();

        $resultatsClasseAvecRang = calculerRangApprenants($resultatsClasse);
        $moyenneClasse = calculerMoyenneClasse($resultatsClasse);

        $maxMoyenne = count($resultatsClasseAvecRang) > 0 ? $resultatsClasseAvecRang[0]['moyenne_details_notes'] : 0;
        $minMoyenne = count($resultatsClasseAvecRang) > 0 ? $resultatsClasseAvecRang[count($resultatsClasseAvecRang) - 1]['moyenne_details_notes'] : 0;

        foreach ($resultatsClasseAvecRang as &$resultat) {
            $resultat['classe_forte_moyenne'] = $maxMoyenne;
            $resultat['classe_faible_moyenne'] = $minMoyenne;
            $resultat['classe_moyenne'] = number_format($moyenneClasse, 2);
            $resultat['classe_effectif'] = count($apprenantsDeLaClasse);
            $resultat['annee_scolaire'] = $annee->libelle;
        }

        // dd($resultatsClasseAvecRang);
        return $resultatsClasseAvecRang;
    }
}


if (!function_exists('calculerRangApprenants')) {
    function calculerRangApprenants($resultatsClasse)
    {
        // Trier le tableau des résultats par la moyenne générale de chaque apprenant de manière décroissante
        usort($resultatsClasse, function ($a, $b) {
            return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
        });

        $rang = 1;
        $position = 1;
        $precedenteMoyenne = null;

        foreach ($resultatsClasse as &$resultat) {
            $moyenne = $resultat['moyenne_details_notes'];

            if ($precedenteMoyenne !== null && $moyenne < $precedenteMoyenne) {
                $rang = $position;
            }

            if ($precedenteMoyenne !== null && $moyenne == $precedenteMoyenne) {
                $resultat['rang'] = ($rang == 1 ? '1er' : $rang . 'e') . ' ex';
            } else {
                $resultat['rang'] = $rang == 1 ? '1er' : $rang . 'e';
            }

            $precedenteMoyenne = $moyenne;
            $position++;
        }

        return $resultatsClasse;
    }
}

if (!function_exists('calculerMoyenneClasse')) {
    function calculerMoyenneClasse($resultatsClasse)
    {
        $totalMoyenneGenerale = 0;
        $nombreApprenants = count($resultatsClasse);

        foreach ($resultatsClasse as $resultat) {
            $totalMoyenneGenerale += $resultat['moyenne_details_notes'];
        }

        // Éviter une division par zéro
        $moyenneClasse = ($nombreApprenants > 0) ? ($totalMoyenneGenerale / $nombreApprenants) : 0;

        return $moyenneClasse;
    }
}


if (!function_exists('ajouterHistoriqueBulletin')) {
    function createHistoriqueBulletin($resultat, $section, $exception = null)
    {
        $groupedDetailsNotes = collect($resultat['details_notes'])->groupBy('type_matiere');
        $noteField = 'moyenne';
        if ($section == 1) {
            $noteField = 'note';
        } elseif ($section == 3) {
            $noteField = 'note_generale';
        }

        $moyenne_litteraire = $groupedDetailsNotes->has('Littéraire') ? round($groupedDetailsNotes->get('Littéraire')->avg($noteField), 2) : 0;
        $moyenne_scientifique = $groupedDetailsNotes->has('Scientifique') ? round($groupedDetailsNotes->get('Scientifique')->avg($noteField), 2) : 0;
        $moyenne_autre = $groupedDetailsNotes->has('Autre') ? round($groupedDetailsNotes->get('Autre')->avg($noteField), 2) : 0;
        // dd($moyenne_litteraire,$moyenne_scientifique,$moyenne_autre);
        //
        // dd('createHistoriqueBulletin', $groupedDetailsNotes);
        $commonFields = [
            'apprenant_id' => $resultat['apprenant_id'],
            'nom_classe' => $resultat['nom_classe'],
            'periode' => $resultat['periode'],
            'classe_annee_id' => $resultat['classe_annee_id'],
            'matricule_apprenant' => $resultat['matricule_apprenant'],
            'nom_prenom_apprenant' => $resultat['nom_prenom_apprenant'],
            'classe_effectif' => $resultat['classe_effectif'],
            'annee_scolaire' => $resultat['annee_scolaire'],
            'classe_forte_moyenne' => $resultat['classe_forte_moyenne'],
            'classe_faible_moyenne' => $resultat['classe_faible_moyenne'],
            'classe_moyenne' => $resultat['classe_moyenne'],
            'moyenne_litteraire' => $moyenne_litteraire,
            'moyenne_scientifique' => $moyenne_scientifique,
            'moyenne_autres_matieres' => $moyenne_autre,
        ];

        foreach ([
            'moyenne_annuelle',
            'rang_annuel',
            'plus_forte_moyenne_annuelle',
            'plus_faible_moyenne_annuelle',
            'moyenne_semestre_1',
            'moyenne_semestre_2',
            'rang_semestre_1',
            'rang_semestre_2',
        ] as $champResultat) {
            if (array_key_exists($champResultat, $resultat)) {
                $commonFields[$champResultat] = $resultat[$champResultat];
            }
        }

        if ($exception == null) {
            $commonFields += [
                'rang' => $resultat['rang']
            ];
        }
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
                    'total_credit' => $resultat['credit']
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
        foreach ($resultat['details_notes'] as $detailNote) {
            ValidationDeSemestre($historiqueBulletin, $detailNote, $section, $resultat);
        }
    }
    function ValidationDeSemestre($historiqueBulletin, $detailNote, $section, $resultat)
    {
        // dd($resultat);
        if ($section == 3) {
            $requetes = DB::select("
                SELECT hn.id,hn.nom_eu ue,hn.historique_bulletin_id,hn.ue_id, (sum(hn.note_generale_coefficiente)/sum(hn.coefficient)) as note_ue FROM historique_notes hn 
                JOIN historique_bulletins hb ON hb.id = hn.historique_bulletin_id
                WHERE hb.id = :historique_bulletin_id group by hn.ue_id
            ", [
                "historique_bulletin_id" => $historiqueBulletin->id
            ]);
            // dd($requetes);
            $validation = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $section)->get();
            if ($validation[0]->regime_validation_id == 1) {
                // Validation par Capitalisation
                foreach ($requetes as $key => $requete) {
                    if ($requete->note_ue < 10) {
                        $historiqueBulletin->validation = 0;
                        $historiqueBulletin->update();
                        $ue_non_valides = HistoriqueNote::where('ue_id', $requete->ue_id)->where('historique_bulletin_id', $historiqueBulletin->id)->get();
                        foreach ($ue_non_valides as $key => $value) {
                            $value->session = 0;
                            $value->update();
                        }
                    }
                }
            } else if ($validation[0]->regime_validation_id  == 2) {
                // Validation par Compansation Orienté
                if ($historiqueBulletin->moyenne_details_notes < 10 && $historiqueBulletin->total_credit < $validation[0]->nbre_credit) {
                    $historiqueBulletin->validation = 0;
                    $historiqueBulletin->update();
                    $ue_non_valides = HistoriqueNote::where('historique_bulletin_id', $historiqueBulletin->id)->get();
                    foreach ($ue_non_valides as $key => $value) {
                        $value->session = 0;
                        $value->update();
                    }
                }
            } else if ($validation[0]->regime_validation_id == 3) {
                // Validation par Compansation Ordinaire
                if ($historiqueBulletin->moyenne_details_notes < 10) {
                    $historiqueBulletin->validation = 0;
                    $historiqueBulletin->update();
                }
            }
        }
    }
    function createHistoriqueNote($historiqueBulletinId, $detailNote, $section)
    {
        $commonFields = [
            'historique_bulletin_id' => $historiqueBulletinId,
            'nom_matiere' => $detailNote['nom_matiere'],
            // Add other common fields here
        ];
        // dd('detailNote', $detailNote);
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
                    'note_de_classe' => $detailNote['note_de_classe'],
                    'note_de_classe_coefficiente' => $detailNote['note_de_classe_coefficiente'],
                    'note_de_composition' => $detailNote['note_de_composition'],
                    'note_de_composition_coefficiente' => $detailNote['note_de_composition_coefficiente'],
                    'moyenne' => $detailNote['moyenne'],
                    'moyenne_coefficiente' => $detailNote['moyenne_coefficiente'],
                ];
                break;
            case 3:
                $commonFields += [
                    'nom_eu' => $detailNote['nom_eu'],
                    'nom_matiere' => $detailNote['nom_matiere'],
                    'ue_id' => $detailNote['id_ue'],
                    'matiere_id' => $detailNote['id_matiere'],
                    'coefficient' => $detailNote['coefficient_matiere'],
                    'volume_horaire_matiere' => $detailNote['volume_horaire_matiere'],
                    'note_origine_devoir' => $detailNote['note_origine_devoir'],
                    'note_origine_examen' => $detailNote['note_origine_examen'],
                    'note_devoir_pourcentage' => $detailNote['note_devoir_pourcentage'],
                    'note_examen_pourcentage' => $detailNote['note_examen_pourcentage'],
                    'note_generale' => $detailNote['note_generale'],
                    'note_generale_coefficiente' => $detailNote['note_generale_coefficiente'],
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
                        createHistoriqueBulletin($resultat, $section, $exception);
                        $checkhistorique->update(['statut' => false]);
                    }
                } else {
                    createHistoriqueBulletin($resultat, $section, $exception);
                    return;
                }
            } else {
                createHistoriqueBulletin($resultat, $section);
            }
        } elseif ($section == 2) {
            if ($exception != null) {
                // dd($resultat);
                $checkhistorique = HistoriqueBulletin::where('classe_annee_id', $resultat['classe_annee_id'])
                    ->where('periode', $resultat['periode'])
                    ->where('apprenant_id', $resultat['apprenant_id'])
                    ->where('statut', true)
                    ->latest()
                    ->first();
                if ($checkhistorique != null) {
                    $communs = array_intersect_assoc($checkhistorique->toArray(), $resultat);
                    $champsAComparer = ['apprenant_id', 'classe_annee_id', 'periode', 'matricule_apprenant', 'nom_prenom_apprenant', 'nom_classe', 'moyenne_details_notes'];

                    foreach ([
                        'moyenne_annuelle',
                        'rang_annuel',
                        'plus_forte_moyenne_annuelle',
                        'plus_faible_moyenne_annuelle',
                        'moyenne_semestre_1',
                        'moyenne_semestre_2',
                        'rang_semestre_1',
                        'rang_semestre_2',
                    ] as $champResultat) {
                        if (array_key_exists($champResultat, $resultat)) {
                            $champsAComparer[] = $champResultat;
                        }
                    }

                    if (empty(array_diff($champsAComparer, array_keys($communs)))) {
                        return;
                    } else {
                        $detailsNotes = $resultat['details_notes'] ?? [];
                        $resultat = collect($resultat)->except(['rang', 'details_notes', 'classe_effectif'])->toArray();
                        // createHistoriqueBulletin($resultat, $section, $exception);
                        $checkhistorique->update($resultat);
                        foreach ($detailsNotes as $detailNote) {
                            $historique_notes = HistoriqueNote::where('historique_bulletin_id', $checkhistorique->id)
                                ->where('nom_matiere', $detailNote['nom_matiere'])
                                ->first();
                            $historique_notes->update($detailNote);
                        }
                    }
                } else {
                    createHistoriqueBulletin($resultat, $section, $exception);
                    return;
                }
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
