<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\ClasseAnnee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\Niveau;
use Modules\GestionNote\Entities\Note;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $headers = [];
        $notes_reforme = [];
        $note_compositions = [];
        $note_interrogations = [];
        $note_devoir_surveilles = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        if ($request->classe != null) {
            $notes_reforme = getNoteByClasses($request->classe);
            if($request->section_id == 1){
                
            }
            if($request->section_id == 2){

            }
            $headers = [
                [
                    'title' => 'Nom',
                    'align' => 'start',
                    'sortable' => false,
                    'key' => 'nom_apprenant',
                ],
            ];
            // Ajout des matières au tableau headers
            foreach (collect($notes_reforme)->pluck('nom_matiere')->unique() as $key => $mat) {
                $headers[] = [
                    'title' => $mat,
                    'align' => 'start',
                    'sortable' => false,
                    'key' => $mat, // Utilisation d'une clé unique pour chaque matière
                ];
            }
            $note_compositions = collect($notes_reforme)->where('type_evaluation', 'Composition')->values();
            $note_interrogations = collect($notes_reforme)->where('type_evaluation', 'Interrogation')->values();
            $note_devoir_surveilles = collect($notes_reforme)->where('type_evaluation', 'Devoir Surveillé')->values();
        }
        return Inertia::render('Rapport/Index', [
            "sectionID" => $request->section_id,
            "notes" => $notes_reforme,
            "headers" => $headers,
            "niveaux" => $niveaux,
            "AllClasses" => $classes,
            "note_compositions" => $note_compositions,
            "note_interrogations" => $note_interrogations,
            "note_devoir_surveilles" => $note_devoir_surveilles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $resultats = [];
        $classes = [];
        if($request->section_id == 1){
            $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
            $classes = getClasses(Annee::find(2)->id, $etablissement_section);
            foreach ($classes as $classe) {
                $resultatsClasse = []; // Tableau pour les résultats de chaque classe
                // dd($classes);
                $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classe->id)->apprenants;
            
                foreach ($apprenantsDeLaClasse as $apprenant) {
                    // dd($apprenant);
                    $notes_apprenant = getNoteByClasses($classe->id, $apprenant->id);
                    $moyenne = calculerMoyennePrimaire($notes_apprenant);
            
                    $details_notes = [];
            
                    foreach ($notes_apprenant as $note) {
                        $details_notes[] = [
                            'nom_matiere' => $note->nom_matiere,
                            'notation_matiere' => $note->notation_matiere,
                            'note' => $note->note
                        ];
                    }
            
                    $resultatsClasse[] = [
                        'classe' => $classe->id,
                        'nom_classe' => $classe->libelle,
                        'apprenant' => $apprenant->id,
                        'matricule_apprenant' => $apprenant->matricule,
                        'nom_apprenant' => $apprenant->nom,
                        'prenom_apprenant' => $apprenant->prenom,
                        'moyenne' => $moyenne,
                        'details_notes' => $details_notes // Tableau des détails des notes
                    ];
                }
                usort($resultatsClasse, function($a, $b) {
                    return $b['moyenne'] <=> $a['moyenne'];
                });

                // Assign the rank to each student within the resultatsClasse array
                $rank = 1;
                foreach ($resultatsClasse as &$resultat) {
                    $resultat['rang'] = $rank++;
                }
            
                $resultats[$classe->id] = $resultatsClasse; // Stocker les résultats de chaque classe dans le tableau principal
            }
            // sleep(5);
            // dd($resultats);
        }else if($request->section_id == 2){
            $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
            $classes = getClasses(Annee::find(2)->id, $etablissement_section);

            if ($request->classe != null) {
                foreach ($classes as $classe) {
                    $resultatsClasse = [];
                    $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($classe->id)->apprenants;
                    foreach ($apprenantsDeLaClasse as $apprenant) {
                        // dd($apprenant);
                        $details_notes = calculerMoyenneSecondaire($classe->id, $apprenant->id);
                        // dd($notestypeComposition, $notesDeClasses, $groupedNotes, $details_notes);
                        $resultatsClasse[] = [
                            'classe' => $classe->id,
                            'nom_classe' => $classe->libelle,
                            'apprenant' => $apprenant->id,
                            'matricule_apprenant' => $apprenant->matricule,
                            'nom_apprenant' => $apprenant->nom,
                            'prenom_apprenant' => $apprenant->prenom,
                            'details_notes' => $details_notes // Tableau des détails des notes
                        ];
                    }

                    foreach ($resultatsClasse as &$resultat) {
                        $totalMoyenne = 0;
                        foreach ($resultat['details_notes'] as $details) {
                            $totalMoyenne += $details['moyenne'];
                        }
                        $resultat['moyenne_details_notes'] = count($resultat['details_notes']) > 0 ? number_format($totalMoyenne / count($resultat['details_notes']), 2) : 0;
                    }

                    // Sort the results by moyenne_details_notes to determine the rank
                    usort($resultatsClasse, function($a, $b) {
                        return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
                    });

                    // Assign the rank to each student within the resultatsClasse array
                    $rank = 1;
                    foreach ($resultatsClasse as &$resultat) {
                        $resultat['rang'] = $rank++;
                    }
                    $resultats[$classe->id] = $resultatsClasse; // Stocker les résultats de chaque classe dans le tableau principal
                }
                // dd('Classe existe', $resultats);
            }
        }
        // dd($classes, 'dd', $resultats);
        return Inertia::render('Rapport/Generation', [
            "sectionID" => $request->section_id,
            "resultats" => $resultats,
            "classes" => $classes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
