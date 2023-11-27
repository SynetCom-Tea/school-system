<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\Cycle;
use App\Models\Etablissement;
use App\Models\HistoriqueBulletin;
use App\Models\HistoriqueNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Filiere;
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

        if($request->type == 0){
            if($request->section == '1' || $request->section == '2'){

                $bulletin = $request->id ? (HistoriqueBulletin::find($request->id) ? HistoriqueBulletin::find($request->id)->with('classe_annee.annee','classe_annee.classe.niveau')->first() : null) : null;
                $detail = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id',$bulletin->id)->get() : [];
                // dd($bulletin,$detail);
                $data = [
                    'etablissement' => $etab,
                    'bulletin' => $bulletin,
                    'detail' => $detail,
                    'section' => $request->section,
                    'title' => 'Bulletin Semestriel',
                    'date' => date('m/d/Y'),
                ];

                $pdf = PDF::loadView('secondaire/bulletin', $data);

            }else if($request->section == '3' || $request->section == '4'){
                $bulletin = $request->id ? (HistoriqueBulletin::find($request->id) ? HistoriqueBulletin::find($request->id)->with('classe_annee.annee','apprenant','historique_notes','classe_annee.classe.niveau')->latest()->first() : null) : null;
                // $detail = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id',$bulletin->id)->get() : [];
                $bulletin->groupUe = $bulletin->historique_notes->groupBy('nom_eu');
                // foreach ($bulletin->groupUe as $ue => $note) {
                //     dump($ue,$note);
                // }
                // dd($bulletin);
                $data = [
                    'etablissement' => $etab,
                    'bulletin' => $bulletin,
                    // 'detail' => $detail,
                    'section' => $request->section,
                    'title' => 'Bulletin Semestriel',
                    'date' => date('m/d/Y'),
                ];
                $pdf = PDF::loadView('superieur/bulletin', $data);
            }

        }elseif($request->type == 1){
            if($request->section == '1' || $request->section == '2'){
                $tabs = [];
                $annee_encours = getAnneeEncours();
                
                $bulletins = $request->classe ?  HistoriqueBulletin::where('statut',1)->whereHas('classe_annee',function($query) use ($request,$annee_encours){
                    $query->where('classe_id',$request->classe)->where('annee_id',$annee_encours->id);
                })->with('classe_annee.annee','classe_annee.classe.niveau')->get() : [];

                foreach ($bulletins as $key => $bulletin) {
                    $details = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id',$bulletin->id)->get() : [];
                    $tabs[$bulletin->apprenant_id]=[
                        'classe' => $bulletin->classe_annee->classe,
                        'bulletin' => $bulletin,
                        'detail' => $details,
                    ];
                }
            
                // dd($tabs);
                $request->classe;
                $data = [
                    'etablissement' => $etab,
                    'section' => $request->section,
                    'donnees' => $tabs,
                    'title' => 'Bulletin Semestriel',
                    'date' => date('m/d/Y'),
                ];
            
                $pdf = PDF::loadView('secondaire/bulletin_par_classe', $data);
            }
        }
        
        
        // dd($data['item']['details_notes']);

        

        return $pdf->stream('itsolutionstuff.pdf');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periode = [];
        $filieres = [];
        $cycle_filieres = [];
        $note_devoirs = [];
        $note_examens = [];
        $headers = [];
        $notes_reforme = [];
        $note_compositions = [];
        $note_interrogations = [];
        $note_devoir_surveilles = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        if ($request->classe != null || $request->classe2 != null) {
            $notes_reforme = getNoteByClasses($request->classe, $request->section_id, $request->periode);
            // dd($notes_reforme, $request->classe);
            if($request->section_id == 1){
                
            }
            if($request->section_id == 2){
                $note_compositions = collect($notes_reforme)->where('type_evaluation', 'Composition')->values();
                $note_interrogations = collect($notes_reforme)->where('type_evaluation', 'Interrogation')->values();
                $note_devoir_surveilles = collect($notes_reforme)->where('type_evaluation', 'Devoir Surveillé')->values();
            }if($request->section_id == 3){
                $note_devoirs = collect($notes_reforme)->where('type_evaluation', 'Examen')->values();
                $note_examens = collect($notes_reforme)->where('type_evaluation', 'Devoir')->values();
                $periode = Periode::where('type',"Semestre")->get();
                $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
                $cycle_filieres = DB::table('cycle_filieres')
                    ->whereIn('filiere_id', $filieres->pluck('id'))
                    ->get();
                //dd($note_devoirs, $note_examens);
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
            //dd($headers);
        }
        return Inertia::render('Rapport/Index', [
            "sectionID" => $request->section_id,
            "filieres" => $filieres,
            "cycle_filieres" => $cycle_filieres,
            "periode" => $periode,
            "notes" => $notes_reforme,
            "headers" => $headers,
            "niveaux" => $niveaux,
            "classes" => $classes,
            "note_compositions" => $note_compositions,
            "note_interrogations" => $note_interrogations,
            "note_devoir_surveilles" => $note_devoir_surveilles,
            "note_devoirs" => $note_devoirs,
            "note_examens" => $note_examens
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $apprenant = null;
        $section = null;
        $resultats = [];
        $classes = [];
        $periode = [];
        $filieres = [];
        $cycle_filieres = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        if($request->section_id == 1){
            $apprenant = 'Élève';
            $section = 'Primaire';
            $periode = Periode::where('type',"Trimestre")->get();
            if ($request->classe != null || $request->classe2 != null) {
                if($request->tab == 'option-1'){
                    $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->get();
                    if ($historiqueBulletincheck->isEmpty()) {
                        $resultats = calculerResultatsClassePrimaire($request->classe, $request->section_id, $etablissement_section, $request->periode);
                        foreach ($resultats as &$resultat) {
                            ajouterHistoriqueBulletin($resultat, $request->section_id);
                        }
                    }
                }
                elseif($request->tab == 'option-2'){
                    dd($request->all());
                }
            }
        }else if($request->section_id == 2){
            $apprenant = 'Élève';
            $section = 'Secondaire';
            $periode = Periode::where('type',"Semestre")->get();
            if ($request->classe != null || $request->classe2 != null) {
                // foreach ($classes as $classe) {
                $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->get();
                if ($historiqueBulletincheck->isEmpty()) {
                    $resultats = calculerResultatsClasse($request->classe, $request->section_id, $request->periode);
                    foreach ($resultats as &$resultat) {
                        // dd($resultat, $resultats);
                        ajouterHistoriqueBulletin($resultat, $request->section_id);
                    }
                    // dd($historiqueBulletincheck, $resultats[0]['periode']);
                } else {
                    $resultats = calculerResultatsClasse($request->classe, $request->section_id, $request->periode);
                }
            }
        }else if($request->section_id == 3){
            $apprenant = 'étudiant';
            $section = 'Supérieure';
            $periode = Periode::where('type',"Semestre")->get();
            $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
            $cycle_filieres = DB::table('cycle_filieres')
                ->whereIn('filiere_id', $filieres->pluck('id'))
                ->get();
            if ($request->classe != null || $request->classe2 != null) {
                $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->get();
                if ($historiqueBulletincheck->isEmpty()) {
                    $resultatsyy = calculerResultatsClasseSuperieure($request->classe, $request->section_id, $request->periode);
                    if (empty($resultatsyy[0]['details_notes'])) {
                        // Le tableau est vide
                    } else {
                        foreach ($resultatsyy as &$resultat) {
                            ajouterHistoriqueBulletin($resultat, $request->section_id);
                        }
                    }
                }
                $resultats = HistoriqueBulletin::with('historique_notes')
                    ->where('classe_annee_id', $request->classe)
                    ->where('periode', Periode::find($request->periode)->libelle)
                    ->get();
            }
        }
        // dd('dd', $resultats);
        return Inertia::render('Rapport/Generation', [
            "sectionID" => $request->section_id,
            "resultats" => $resultats,
            "classes" => $classes,
            'periodes'=> $periode,
            "filieres" => $filieres,
            "cycle_filieres" => $cycle_filieres,
            'apprenant' => $apprenant,
            'section' => $section
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
