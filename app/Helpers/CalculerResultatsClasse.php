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
use Illuminate\Support\Facades\DB;

if (!function_exists('calculerResultatsClasse')) {
    function calculerResultatsClasse($classeId, $section, $etablissement_section, $periode, $apprenants = null)
    {
        $resultatsClasse = [];
        $annee = Annee::where('actif', 1)->first();
        $classe = getClasses($annee->id, $etablissement_section, $classeId)->first();

        if ($classe) {
            $classeAnneeId = $classe->classe_annee_id;
        } else {
            $classeAnnee = ClasseAnnee::with('classe')->findOrFail($classeId);
            $classeAnneeId = $classeAnnee->id;
            $classe = getClasses($annee->id, $etablissement_section, $classeAnnee->classe_id)->firstOrFail();
        }

        if ($apprenants != null) {
            $apprenantsDeLaClasse = $apprenants;
            // dd($apprenants);
        } else {
            $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeAnneeId)->apprenants;
        }
        // dd($apprenantsDeLaClasse);
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $details_notes = calculerMoyenneSecondaire($classeAnneeId, $section, $periode, $apprenant->id);
            if (empty($details_notes)) {
                break; // Exit the function if $details_notes is empty
            }
            
            
            
            $resultatsClasse[$apprenant->id] = [
                'classe_annee_id' => $classeAnneeId,
                'periode' => $details_notes[0]['periodes'],
                'nom_classe' => $classe->code,
                'apprenant_id' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_prenom_apprenant' => $apprenant->nom . ' ' . $apprenant->prenom,
                'details_notes' => $details_notes, // Tableau des détails des notes
                'moyenne_details_notes' => 0, // Initialiser à 0, sera calculé plus tard
                'somme_notation' => array_sum(array_column($details_notes, 'note_de_classe')), // Somme des notations
                'somme_note_generale' => array_sum(array_column($details_notes, 'moyenne')), // Somme des notes générales
                'rang' => 0, // Initialiser à 0, sera calculé plus tard
                'classe_effectif' => count($apprenantsDeLaClasse),
                'annee_scolaire' => $annee->libelle,
                'classe_forte_moyenne' => 0,
                'classe_faible_moyenne' => 0,
                'classe_moyenne' => 0

            ];
            // dd('details_notes', $details_notes, $resultatsClasse);
        }
        // dd('resultatsClasse', $resultatsClasse);
        // Transformer le tableau associatif en tableau indexé pour trier
        $resultatsClasse = array_values($resultatsClasse);

        foreach ($resultatsClasse as &$resultat) {
            
            $resultat['moyenne_details_notes'] = calculateMoyenneGeneralSecondaire($resultat['details_notes']);
        }
        // dd('resultatsClasse avant tri', $resultatsClasse);
        // Trier par moyenne décroissante
        usort($resultatsClasse, function ($a, $b) {
            return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
        });
        // dd($resultatsClasse);
        // Récupérer toutes les moyennes des élèves
        $moyennesClasse = array_column($resultatsClasse, 'moyenne_details_notes');

        // Moyenne générale de la classe
        $moyenne_de_la_Classe = count($moyennesClasse) > 0 ? number_format(array_sum($moyennesClasse) / count($moyennesClasse), 2) : 0;
        // Max et Min de la classe
        $maxMoyenne = $resultatsClasse[0]['moyenne_details_notes'];
        $minMoyenne = $resultatsClasse[count($resultatsClasse) - 1]['moyenne_details_notes'];
        // dd('maxMin', $maxMoyenne, $minMoyenne);

        // Fonction d'affichage du rang
        function formatRang($n, $ex = false)
        {
            return $ex ? $n . 'e ex' : $n . 'e';
        }

        // Calcul des rangs avec ex æquo
        $rang = 1;
        $positionsParMoyenne = [];

        foreach ($resultatsClasse as &$resultat) {
            // dd('resultatsClasse avant rang', $resultatsClasse);
            $moyenne = $resultat['moyenne_details_notes'];

            if (!isset($positionsParMoyenne[$moyenne])) {
                $positionsParMoyenne[$moyenne] = $rang;
                $resultat['rang'] = formatRang($rang);
            } else {
                $resultat['rang'] = formatRang($positionsParMoyenne[$moyenne], true);
            }

            // Injecter max et min dans chaque élève
            $resultat['classe_forte_moyenne'] = $maxMoyenne;
            $resultat['classe_faible_moyenne'] = $minMoyenne;
            $resultat['classe_moyenne'] = $moyenne_de_la_Classe;

            $rang++;
        }

        // dd('resultatsClasse final', $resultatsClasse);

        // Calculate annual results if it's Semestre II
        $resultatsClasse = calculerResultatsAnnuels($resultatsClasse, $classeAnneeId, $resultatsClasse[0]['periode'] ?? '');

        return $resultatsClasse;
    }
}

if (!function_exists('calculerResultatsClassePrimaire')) {

    function calculerResultatsClassePrimaire($classeId, $section, $etablissement_section, $periode, $apprenants = null)
    {
        $annee = Annee::where('actif', 1)->first();

        // dd(Annee::all(), $classeId);
        $resultatsClasse = [];
        $classe = getClasses($annee->id, $etablissement_section, $classeId)->firstOrFail();
        $classe_annee_id = ClasseAnnee::where('classe_id', $classeId)->where('annee_id', $annee->id)->first()->id;
        // dd('Calcul', $classe);
        if ($apprenants != null) {
            $apprenantsDeLaClasse = $apprenants;
            // dd($apprenants);
        } else {
            $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->where('classe_id', $classeId)->where('annee_id', $annee->id)->first()->apprenants;
        }
        // dd('apprenantsDeLaClasse',$apprenantsDeLaClasse);
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $notes_apprenant = getNoteByClasses($classe_annee_id, $section, $periode, $apprenant->id);
            $moyenne = calculerMoyennePrimaire($notes_apprenant);
            $notes = array_column($notes_apprenant->toArray(), 'note');
            $sommeNotes = array_sum($notes);
            $notations = array_column($notes_apprenant->toArray(), 'notation_matiere');
            $sommeNotations = array_sum($notations);
            // Initialize $details_notes for each apprenant
            $details_notes = [];

            foreach ($notes_apprenant as $note) {
                $details_notes[] = [
                    'nom_matiere' => $note->nom_matiere,
                    'notation_matiere' => $note->notation_matiere,
                    'note' => $note->note
                ];
            }
            // dd('notes_apprenant', $notes_apprenant);
            $resultatsClasse[] = [
                'classe_annee_id' => $classe_annee_id,
                'periode' => $notes_apprenant[0]->periode,
                'nom_classe' => $classe->code,
                'apprenant_id' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_prenom_apprenant' => $apprenant->nom . ' ' . $apprenant->prenom,
                'moyenne_details_notes' => $moyenne,
                'details_notes' => $details_notes, // Tableau des détails des notes
                'somme_notation' => $sommeNotations,
                'somme_note_generale' => $sommeNotes
            ];
        }
        // Transformer le tableau associatif en tableau indexé pour trier
        $resultatsClasse = array_values($resultatsClasse);

        usort($resultatsClasse, function ($a, $b) {
            return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
        });

        $rank = 1;
        $prevRank = 1;

        foreach ($resultatsClasse as &$resultat) {
            $resultat['rang'] = ($prevRank === $rank) ? '=' . $rank : $rank;
            $prevRank = $rank;
            $rank++;
            // dump($resultat);
        }
        // die();

        return $resultatsClasse;
    }
}
