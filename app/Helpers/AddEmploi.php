<?php


/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\Annee;
use App\Models\ClasseAnnee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Emploi\Entities\Emploi;
use Modules\Emploi\Entities\Horaire;

if (!function_exists('addEmploi')) {
        function addEmploi($request) {
            
            // dd($request->all());
        $dateDebut = Carbon::parse($request->date[0]);
        $dateFin = Carbon::parse($request->date[1]);
        $occurrences = countWeekdayOccurrences($dateDebut, $dateFin, $request->seances);
        // dd($occurrences);
        $annee = Annee::where('actif',1)->first();
        $classeAnnee = ClasseAnnee::where('annee_id', $annee->id)
            ->where('classe_id', $request->classe)
            ->first();
        // dd($classeAnnee, $request->classe, Annee::find(2)->id);
        try {
            $emploi = Emploi::create([
                'date_debut' => $request->date[0],
                'date_fin' => $request->date[1],
                'classe_annee_id' => $classeAnnee->id
            ]);
            foreach ($occurrences as $jour => $seancesDuJour) {
                // Vérifie s'il y a des horaires pour ce jour
                if (count($seancesDuJour['seances']) > 0 && $seancesDuJour['seances'][0]['matiere'] != null) {
                    // Récupère les horaires pour ce jour
                    foreach ($seancesDuJour['seances'] as $seance) {
                        for ($i = 0; $i < $seancesDuJour['occurrences']; $i++) {
                            if ($seance['matiere'] != null) {
                                $dateSeance = (new DateTime($seancesDuJour['date_debut']))->add(new DateInterval('P' . ($i * 7) . 'D'));
                                // Vérifiez si $seance['salle'] existe
                                if (isset($seance['salle'])) {
                                    $salleId = $seance['salle'];
                                } else {
                                    $salleId = null;
                                }
                                Horaire::create([
                                    'heure_debut' => sprintf('%02d:%02d:%02d', $seance['horaire'][0]['hours'], $seance['horaire'][0]['minutes'], $seance['horaire'][0]['seconds']),
                                    'heure_fin' => sprintf('%02d:%02d:%02d', $seance['horaire'][1]['hours'], $seance['horaire'][1]['minutes'], $seance['horaire'][1]['seconds'])
                                ])->seances()->create([
                                    'statut' => false,
                                    'niveau_matiere_id' => DB::table('niveau_matieres')
                                        ->where('niveau_id', $request->niveau)
                                        ->where('matiere_id', $seance['matiere'])
                                        ->first()->id,
                                    'emploi_id' => $emploi->id,
                                    'salle_id' => $salleId,
                                    'date_seance' => $dateSeance->format('Y-m-d'),
                                    'heure_debut' => sprintf('%02d:%02d:%02d', $seance['horaire'][0]['hours'], $seance['horaire'][0]['minutes'], $seance['horaire'][0]['seconds']),
                                    'heure_fin' => sprintf('%02d:%02d:%02d', $seance['horaire'][1]['hours'], $seance['horaire'][1]['minutes'], $seance['horaire'][1]['seconds'])
                                ]);
                            }
                        }
                    }
                }
            }
        }catch (\Exception $exception) {
            dd($exception);
            DB::rollBack();
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
        DB::commit();
        return redirect()->route('emplois.index', $request->section_id)->with('message', [
            'type' => 'success',
            'text' => "Emploi ajouter avec success !",
        ]);
        }
    }