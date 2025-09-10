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
    function calculerResultatsClasse($classeId, $section, $etablissement_section, $periode, $apprenants = null) {
        $resultatsClasse = [];
        $annee = Annee::where('actif',1)->first();
        $classe = getClasses($annee->id, $etablissement_section, $classeId)->firstOrFail();
        if($apprenants != null){
            $apprenantsDeLaClasse = $apprenants;
            // dd($apprenants);
        }else{
            $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classeId)->apprenants;
        }
        //dd($apprenantsDeLaClasse);
        foreach ($apprenantsDeLaClasse as $apprenant) {
            $details_notes = calculerMoyenneSecondaire($classeId, $section, $periode, $apprenant->id);
            if (empty($details_notes)) {
                return; // Exit the function if $details_notes is empty
            }        
            $resultatsClasse[$apprenant->id] = [
                'classe_annee_id' => $classeId,
                'periode' => $details_notes[0]['periodes'],
                'nom_classe' => $classe->libelle,
                'apprenant_id' => $apprenant->id,
                'matricule_apprenant' => $apprenant->matricule,
                'nom_prenom_apprenant' => $apprenant->nom . ' ' . $apprenant->prenom,
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
    
    function calculerResultatsClassePrimaire($classeId, $section, $etablissement_section, $periode, $apprenants = null){
        $annee = Annee::where('actif',1)->first();

        // dd(Annee::all(), $classeId);
        $resultatsClasse = [];
        $classe = getClasses($annee->id, $etablissement_section, $classeId)->firstOrFail();
        $classe_annee_id = ClasseAnnee::where('classe_id', $classeId)->where('annee_id', $annee->id)->first()->id;
        // dd('Calcul', $classe);
        if($apprenants != null){
            $apprenantsDeLaClasse = $apprenants;
            // dd($apprenants);
        }else{
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
                'nom_classe' => $classe->libelle,
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
