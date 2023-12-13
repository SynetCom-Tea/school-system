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
    function calculerResultatsClasseSuperieure($classeId, $section, $etablissement_section, $periode, $apprenants = null) {
        $resultatsClasse = [];
        $classe = getClasses(Annee::find(2)->id, $etablissement_section, $classeId)->firstOrFail();
        // dd($classe);
        if($apprenants != null){
            $apprenantsDeLaClasse = $apprenants;
            // dd($apprenants);
        }else{
            $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        }
        foreach ($apprenantsDeLaClasse as $key=>$apprenant) {
            $resultatMoyenne = calculerMoyenneSuperierure($classeId, $apprenant->id, $section, $periode);
            $resultatsClasse[$apprenant->id] = [
                'classe_annee_id' => $classeId,
                'periode' => $resultatMoyenne['periode'],
                'nom_classe' => $classe->libelle,
                'apprenant_id' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_prenom_apprenant' => $apprenant->nom . ' ' . $apprenant->prenom,
                'total_volume_horaire' => $resultatMoyenne['total_volume_horaire'],
                'total_coefficient' => $resultatMoyenne['total_coefficient'],
                'somme_note_generale' => $resultatMoyenne['somme_note_generale'],
                'credit'=>$resultatMoyenne['credit'],
                'somme_note_generale_coefficient' => $resultatMoyenne['somme_note_generale_coefficient'],
                'moyenne_details_notes' => $resultatMoyenne['moyenne_generale'],
                'details_notes' => $resultatMoyenne['details_notes'], // Tableau des détails des notes
            ];
            // foreach ($resultatsClasse[$apprenant->id]['details_notes'] as $key => $value) {
            //     $credit_total = 0;
            //     if ($value['note_generale']>=10){
            //         // $credit_total = $value['coefficient_matiere'];
            //         dump(collect($value)->sum('coefficient_matiere'));
            //     }
            //     // dump($credit_total);
            // }
            // dump($resultatsClasse);
            // dump($resultatsClasse[$apprenant->id]['details_notes']);
        }
        // die();
        
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
            return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
        });

        $rang = 1;
        $classement_precedent = null;

        foreach ($resultatsClasse as &$resultat) {
            if ($classement_precedent !== null && $resultat['moyenne_details_notes'] < $classement_precedent) {
                $rang++;
            }
            $resultat['rang'] = $rang;
            $classement_precedent = $resultat['moyenne_details_notes'];
        }

        return $resultatsClasse;
    }
}

if (!function_exists('calculerMoyenneClasse')) {
    function calculerMoyenneClasse($resultatsClasse) {
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
    function createHistoriqueBulletin($resultat, $section)
    {
        // dd($resultat);
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
                    'total_credit'=>$resultat['credit']
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
            ValidationDeSemestre($historiqueBulletin, $detailNote, $section,$resultat);
        }
    }
    function ValidationDeSemestre($historiqueBulletin, $detailNote, $section,$resultat){
        // dd($resultat);
        if ($section == 3){
            $requetes = DB::select("
                SELECT hn.id,hn.nom_eu ue,hn.historique_bulletin_id,hn.ue_id, (sum(hn.note_generale_coefficiente)/sum(hn.coefficient)) as note_ue FROM historique_notes hn 
                JOIN historique_bulletins hb ON hb.id = hn.historique_bulletin_id
                WHERE hb.id = :historique_bulletin_id group by hn.ue_id
            ",[
                "historique_bulletin_id"=>$historiqueBulletin->id
            ]);
            $validation = DB::table('etablissement_section')->where('etablissement_id',Auth::user()->etablissement_id)->where('section_id',$section)->get();
            if ($validation[0]->regime_validation_id == 1){
                // Validation par Capitalisation
                foreach ($requetes as $key => $requete) {
                    if ($requete->note_ue<10){
                        $historiqueBulletin->validation = 0 ;
                        $historiqueBulletin->update();
                        $ue_non_valides = HistoriqueNote::where('ue_id',$requete->ue_id)->where('historique_bulletin_id',$historiqueBulletin->id)->get();
                        foreach ($ue_non_valides as $key => $value) {
                            $value->session = 0;
                            $value->update();
                        }
                    }
                }
            }else if($validation[0]->regime_validation_id  == 2){
                // Validation par Compansation Orienté
                if ($historiqueBulletin->moyenne_details_notes<10 && $historiqueBulletin->total_credit<$validation[0]->nbre_credit){
                    $historiqueBulletin->validation = 0 ;
                    $historiqueBulletin->update();
                    $ue_non_valides = HistoriqueNote::where('historique_bulletin_id',$historiqueBulletin->id)->get();
                    foreach ($ue_non_valides as $key => $value) {
                        $value->session = 0;
                        $value->update();
                    }
                }
            }else if ($validation[0]->regime_validation_id == 3){
                // Validation par Compansation Ordinaire
                if ($historiqueBulletin->moyenne_details_notes<10){
                    $historiqueBulletin->validation = 0 ;
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
                $checkhistorique = HistoriqueBulletin::where('classe_annee_id', $resultat['classe_annee_id'])
                ->where('periode', $resultat['periode'])
                ->where('apprenant_id', $resultat['apprenant_id'])
                ->where('statut', true)
                ->latest()
                ->first();
                if ($checkhistorique != null) {
                    $communs = array_intersect_assoc($checkhistorique->toArray(), $resultat);
                    if (empty(array_diff(['apprenant_id', 'classe_annee_id', 'periode', 'matricule_apprenant', 'nom_prenom_apprenant', 'nom_classe', 'moyenne_details_notes'], array_keys($communs)))) {
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
        } elseif ($section == 3) {
            if ($exception != null) {
                // Handle exception for section 3 if needed
            } else {
                createHistoriqueBulletin($resultat, $section);
            }
        }
        
    }
}
