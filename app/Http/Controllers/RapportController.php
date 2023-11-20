<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\Etablissement;
use App\Models\HistoriqueBulletin;
use App\Models\HistoriqueNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\Niveau;
use Modules\GestionNote\Entities\Note;
use Modules\GestionNote\Entities\Periode;

use PDF;

class RapportController extends Controller
{

    public function bulletin(Request $request)
    {
        // dd($request->all());
        $etab = Etablissement::find(Auth::user()->etablissement_id);
        $pdf = PDF::loadView('superieur/bulletin');
        // if($request->type == 0){
        //     $bulletin = $request->id ? (HistoriqueBulletin::find($request->id) ? HistoriqueBulletin::find($request->id)->with('classe_annee.annee','classe_annee.classe.niveau')->first() : null) : null;
        //     $detail = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id',$bulletin->id)->get() : [];
        //     // dd($bulletin,$detail);
        //     $data = [
        //         'etablissement' => $etab,
        //         'bulletin' => $bulletin,
        //         'detail' => $detail,
        //         'section' => $request->section,
        //         'title' => 'Bulletin Semestriel',
        //         'date' => date('m/d/Y'),
        //     ];

        //     $pdf = PDF::loadView('secondaire/bulletin', $data);

        // }elseif($request->type == 1){
        //     $tabs = [];
        //     $annee_encours = getAnneeEncours();
        //     $bulletins = $request->classe ?  HistoriqueBulletin::where('statut',1)->whereHas('classe_annee',function($query) use ($request,$annee_encours){
        //         $query->where('classe_id',$request->classe)->where('annee_id',$annee_encours->id);
        //     })->with('classe_annee.annee','classe_annee.classe.niveau')->get() : [];

        //     foreach ($bulletins as $key => $bulletin) {
        //         $details = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id',$bulletin->id)->get() : [];
        //         $tabs[$bulletin->apprenant_id]=[
        //             'classe' => $bulletin->classe_annee->classe,
        //             'bulletin' => $bulletin,
        //             'detail' => $details,
        //         ];
        //     }
            
        //     // dd($tabs);
        //     $request->classe;
        //     $data = [
        //         'etablissement' => $etab,
        //         'section' => $request->section,
        //         'donnees' => $tabs,
        //         'title' => 'Bulletin Semestriel',
        //         'date' => date('m/d/Y'),
        //     ];

        //     $pdf = PDF::loadView('secondaire/bulletin_par_classe', $data);
        // }
        
        
        // dd($data['item']['details_notes']);

        

        return $pdf->stream('itsolutionstuff.pdf');
    }
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
        $periode = [];
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
                    if ($b['moyenne'] === $a['moyenne']) {
                        return 0; // If averages are equal, retain the same order to manage ties
                    }
                    return $b['moyenne'] <=> $a['moyenne'];
                });
            
                // Assign the rank to each student within the resultatsClasse array
                $rang = 1;
                $rangPrecedent = 1;
                foreach ($resultatsClasse as &$resultat) {
                    $resultat['rang'] = ordinalSuffix($rang);
                    $rangPrecedent = $rang;
                    $rang++;
                }
            
                $resultats[$classe->id] = $resultatsClasse; // Stocker les résultats de chaque classe dans le tableau principal
            }
            // sleep(5);
            // dd($resultats);
        }else if($request->section_id == 2){
            $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
            $classes = getClasses(Annee::find(2)->id, $etablissement_section);
            $periode = $request->section_id ? Periode::where('type',"Semestre")->get():collect();
            if ($request->classe != null) {
                // foreach ($classes as $classe) {
                $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->get();
                if ($historiqueBulletincheck->isEmpty()) {
                    $resultatsClasse = [];
                    $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($request->classe)->apprenants;
    
                    foreach ($apprenantsDeLaClasse as $apprenant) {
                        $details_notes = calculerMoyenneSecondaire($request->classe, $apprenant->id);
    
                        $resultatsClasse[$apprenant->id] = [
                            'classe' => $request->classe,
                            'periode' => $details_notes[0]['periodes'],
                            'nom_classe' => $classes->find($request->classe)->libelle,
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
    
                    usort($resultatsClasse, function($a, $b) {
                        return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
                    });
    
                    $rank = 1;
                    $prevRank = 1;
    
                    foreach ($resultatsClasse as &$resultat) {
                        $resultat['rang'] = ($prevRank === $rank) ? '=' . $rank : $rank;
                        $prevRank = $rank;
                        $rank++;
                    }
    
                    $resultats = $resultatsClasse;

                    foreach ($resultats as &$resultat) {
                        // dd($resultat, $resultats);
                        $historiqueBulletin = HistoriqueBulletin::create([
                            'apprenant_id' => $resultat['apprenant'],
                            'nom_classe' => $resultat['nom_classe'],
                            'periode' => $resultat['periode'],
                            'classe_annee_id' => $resultat['classe'],
                            'matricule_apprenant' => $resultat['matricule_apprenant'],
                            'nom_prenom_apprenant' => $resultat['nom_apprenant'] . ' ' . $resultat['prenom_apprenant'],
                            'moyenne_details_notes' => $resultat['moyenne_details_notes'],
                            'rang' => $resultat['rang'],
                        ]);

                        foreach ($resultat['details_notes'] as $detailNote) {
                            HistoriqueNote::create([
                                'historique_bulletin_id' => $historiqueBulletin->id,
                                'nom_matiere' => $detailNote['nom_matiere'],
                                'coefficient' => $detailNote['coefficient'],
                                'note_de_classe' => $detailNote['noteDeClasse'],
                                'note_de_classe_coefficiente' => $detailNote['noteDeClasseCoefficiente'],
                                'note_de_composition' => $detailNote['noteDeComposition'],
                                'note_de_composition_coefficiente' => $detailNote['noteDeCompositionCoefficiente'],
                                'moyenne' => $detailNote['moyenne'],
                                'moyenne_coefficiente' => $detailNote['moyenneCoefficiente'],
                            ]);
                        }
                    }
                    // dd($historiqueBulletincheck, $resultats[0]['periode']);
                } else {
                    $resultatsClasse = [];
                    $apprenantsDeLaClasse = ClasseAnnee::with('apprenants')->find($request->classe)->apprenants;
    
                    foreach ($apprenantsDeLaClasse as $apprenant) {
                        $details_notes = calculerMoyenneSecondaire($request->classe, $apprenant->id);
    
                        $resultatsClasse[$apprenant->id] = [
                            'classe' => $request->classe,
                            'periode' => $details_notes[0]['periodes'],
                            'nom_classe' => $classes->find($request->classe)->libelle,
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
    
                    usort($resultatsClasse, function($a, $b) {
                        return $b['moyenne_details_notes'] <=> $a['moyenne_details_notes'];
                    });
    
                    $rank = 1;
                    $prevRank = 1;
    
                    foreach ($resultatsClasse as &$resultat) {
                        $resultat['rang'] = ($prevRank === $rank) ? '=' . $rank : $rank;
                        $prevRank = $rank;
                        $rank++;
                    }
    
                    $resultats = $resultatsClasse;
                }
            }
        }
        // dd($classes, 'dd', $resultats);
        return Inertia::render('Rapport/Generation', [
            "sectionID" => $request->section_id,
            "resultats" => $resultats,
            "classes" => $classes,
            'periodes'=>$periode,
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
