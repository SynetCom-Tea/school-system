<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Apprenant;
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
use Modules\GestionNote\Entities\TypeEvaluation;
use PDF;

class RapportController extends Controller
{

    public function bulletin(Request $request)
    {
        // dd($request->all());
        $etab = Etablissement::find(Auth::user()->etablissement_id);
        $annee_encours = getAnneeEncours();
        $periode = $request->periode ? Periode::find($request->periode) : null;
        if ($request->type == 0) {

            if ($request->section == '1') {
                // dd('fin');
                $bulletin = $request->id ? HistoriqueBulletin::where('id', $request->id)->with('classe_annee.annee', 'classe_annee.classe.niveau')->first() : null;
                $detail = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id', $bulletin->id)->get() : [];
                // dd($bulletin,$detail);
                $data = [
                    'etablissement' => $etab,
                    'bulletin' => $bulletin,
                    'notes' => $detail,
                    'total_point' => $bulletin->somme_note_generale,
                    'total_notation' => $bulletin->somme_notation,
                    'section' => $request->section,
                    'title' => 'Bulletin Trimestriel',
                    'date' => date('m/d/Y'),
                ];

                $pdf = PDF::loadView('primaire/bulletin', $data)->setPaper('A4', 'landscape');
            } elseif ($request->section == '2') {

                $bulletin = $request->id ? HistoriqueBulletin::where('id', $request->id)->with('classe_annee.annee', 'classe_annee.classe.niveau')->first() : null;
                $detail = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id', $bulletin->id)->get() : [];
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
            } else if ($request->section == '3') {
                $bulletin = $request->id ? HistoriqueBulletin::where('id', $request->id)->with('classe_annee.annee', 'apprenant', 'historique_notes', 'classe_annee.classe.niveau')->first() : null;
                // $detail = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id',$bulletin->id)->get() : [];
                $bulletin->groupUe = $bulletin->historique_notes->groupBy('nom_eu');
                // foreach ($bulletin->groupUe as $ue => $note) {
                //     dump($ue,$note);
                // }
                // dd($request->id,$bulletin);
                $data = [
                    'etablissement' => $etab,
                    'bulletin' => $bulletin,
                    'section' => $request->section,
                    'title' => 'Bulletin Semestriel',
                    'date' => date('m/d/Y'),
                ];
                $pdf = PDF::loadView('superieur/bulletin', $data);
            }
        } elseif ($request->type == 1) {
            if ($request->section == '1') {
                $tabs = [];
                $bulletins = $request->classe && $periode ?  HistoriqueBulletin::where('statut', 1)->where('periode', $periode->libelle)->whereHas('classe_annee', function ($query) use ($request, $annee_encours) {
                    $query->where('classe_id', $request->classe)->where('annee_id', $annee_encours->id);
                })->with('classe_annee.annee', 'classe_annee.classe.niveau')->get() : [];

                foreach ($bulletins as $key => $bulletin) {
                    $details = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id', $bulletin->id)->get() : [];
                    $tabs[$bulletin->apprenant_id] = [
                        'classe' => $bulletin->classe_annee->classe,
                        'bulletin' => $bulletin,
                        'detail' => $details,
                    ];
                }
                // dd($tabs);
                $data = [
                    'etablissement' => $etab,
                    'donnees' => $tabs,
                    'total_point' => reset($tabs)['bulletin']->somme_note_generale,
                    'total_notation' => reset($tabs)['bulletin']->somme_notation,
                    'section' => $request->section,
                    'title' => 'Bulletin Trimestriel',
                    'date' => date('m/d/Y'),
                ];

                $pdf = PDF::loadView('primaire/bulletin_par_classe', $data)->setPaper('A4', 'landscape');
            } elseif ($request->section == '2') {
                $tabs = [];
                $bulletins = $request->classe && $periode ?  HistoriqueBulletin::where('statut', 1)->where('periode', $periode->libelle)->whereHas('classe_annee', function ($query) use ($request, $annee_encours) {
                    $query->where('classe_id', $request->classe)->where('annee_id', $annee_encours->id);
                })->with('classe_annee.annee', 'classe_annee.classe.niveau')->get() : [];

                foreach ($bulletins as $key => $bulletin) {
                    $details = !is_null($bulletin) ? HistoriqueNote::where('historique_bulletin_id', $bulletin->id)->get() : [];
                    $tabs[$bulletin->apprenant_id] = [
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
        $check = false;
        $notes = [];
        $periode = [];
        $types = [];
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
        if ($request->section_id == 3) {
            $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
            $cycle_filieres = DB::table('cycle_filieres')
                ->whereIn('filiere_id', $filieres->pluck('id'))
                ->get();
        }
        // dd($classes);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        if ($request->classe != null || $request->classe2 != null) {
            $notes_reforme = getNoteByClasses($request->classe, $request->section_id, $request->periode);
            // dd($notes_reforme, $request->classe);
            if ($request->section_id == 1) {
                $typesNotIn = ['TP', 'Examen', 'Devoir', 'Interrogation', 'Autre', 'Devoir / Devoir Surveillé'];
                $periode = Periode::where('type', "Trimestre")->get();
            }
            if ($request->section_id == 2) {
                $typesNotIn = ['TP', 'Autre', 'Contrôle'];
                $periode = Periode::where('type', "Semestre")->get();
                $note_compositions = collect($notes_reforme)->where('type_evaluation', 'Composition')->values();
                $note_interrogations = collect($notes_reforme)->where('type_evaluation', 'Interrogation')->values();
                $note_devoir_surveilles = collect($notes_reforme)->where('type_evaluation', 'Devoir Surveillé')->values();
            }
            if ($request->section_id == 3) {
                $typesNotIn = ['Composition', 'Devoir', 'Interrogation', 'Contrôle'];
                $note_devoirs = collect($notes_reforme)->where('type_evaluation', 'Examen')->values();
                $note_examens = collect($notes_reforme)->where('type_evaluation', 'Devoir')->values();
                $periode = Periode::where('type', "Semestre")->get();
                // dd($filieres);
            }
            $types = TypeEvaluation::whereNotIn('libelle', $typesNotIn)->get();
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
            if ($request->type_evaluation != null) {
                $notes = collect($notes_reforme)->where('type_evaluation', $request->type_evaluation)->values();
                $check = true;
            }
        }
        return Inertia::render('Rapport/Index', [
            "check" => $check,
            "sectionID" => $request->section_id,
            "filieres" => $filieres,
            "cycle_filieres" => $cycle_filieres,
            "periodes" => $periode,
            "notes" => $notes,
            "headers" => $headers,
            "niveaux" => $niveaux,
            "AllClasses" => $classes,
            "note_compositions" => $note_compositions,
            "note_interrogations" => $note_interrogations,
            "note_devoir_surveilles" => $note_devoir_surveilles,
            "note_devoirs" => $note_devoirs,
            "note_examens" => $note_examens,
            "types" => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $premieregeneration = false;
        $apprenants = [];
        $apprenant = null;
        $section = null;
        $resultats = [];
        $classes = [];
        $periode = [];
        $filieres = [];
        $cycle_filieres = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        if ($request->section_id == 1) {
            $apprenant = 'Élève';
            $section = 'Primaire';
            $periode = Periode::where('type', "Trimestre")->get();
            if ($request->classe != null || $request->classe2 != null) {
                if ($request->tab == 'option-1') {
                    $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->get();
                    if ($historiqueBulletincheck->isEmpty()) {
                        $premieregeneration = true;
                        $resultats = calculerResultatsClassePrimaire($request->classe, $request->section_id, $etablissement_section, $request->periode);
                        foreach ($resultats as &$resultat) {
                            ajouterHistoriqueBulletin($resultat, $request->section_id);
                        }
                    }
                    $resultats = HistoriqueBulletin::with('historique_notes')
                        ->where('classe_annee_id', $request->classe)
                        ->where('periode', Periode::find($request->periode)->libelle)
                        ->where('statut', true)
                        ->get();
                } elseif ($request->tab == 'option-2') {
                    $exception = true;
                    $apprenants = ClasseAnnee::with('apprenants')->find($request->classe)->apprenants()->get();
                    if ($request->apprenant != null) {
                        // Convertir la chaîne en tableau en utilisant la virgule comme délimiteur
                        $apprenantIds = explode(',', $request->apprenant);
                        // Supprimer les espaces autour de chaque ID
                        $apprenantIds = array_map('trim', $apprenantIds);
                        $apprenantsSelect = Apprenant::whereIn('id', $apprenantIds)->get();
                        $resultatstz = calculerResultatsClassePrimaire($request->classe, $request->section_id, $etablissement_section, $request->periode, $apprenantsSelect);
                        // dd($apprenantIds, $apprenantsSelect, $resultatstz);
                        foreach ($resultatstz as &$resultat) {
                            ajouterHistoriqueBulletin($resultat, $request->section_id, $exception);
                        }
                    }
                }
            }
        } else if ($request->section_id == 2) {
            $apprenant = 'Élève';
            $section = 'Secondaire';
            $periode = Periode::where('type', "Semestre")->get();
            if ($request->classe != null || $request->classe2 != null) {
                if ($request->tab == 'option-1') {
                    $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->get();
                    if ($historiqueBulletincheck->isEmpty()) {
                        $resultats = calculerResultatsClasse($request->classe, $request->section_id, $etablissement_section, $request->periode);
                        if (empty($resultats)) {
                            return; // Exit the function if $details_notes is empty
                        }
                        foreach ($resultats as &$resultat) {
                            ajouterHistoriqueBulletin($resultat, $request->section_id);
                        }
                        // dd($historiqueBulletincheck, $resultats[0]['periode']);
                    }
                    $resultats = HistoriqueBulletin::with('historique_notes')
                        ->where('classe_annee_id', $request->classe)
                        ->where('periode', Periode::find($request->periode)->libelle)
                        ->where('statut', true)
                        ->get();
                } elseif ($request->tab == 'option-2') {
                    $exception = true;
                    $apprenants = ClasseAnnee::with('apprenants')->find($request->classe)->apprenants()->get();
                    if ($request->apprenant != null) {
                        // Convertir la chaîne en tableau en utilisant la virgule comme délimiteur
                        $apprenantIds = explode(',', $request->apprenant);
                        // Supprimer les espaces autour de chaque ID
                        $apprenantIds = array_map('trim', $apprenantIds);
                        $apprenantsSelect = Apprenant::whereIn('id', $apprenantIds)->get();
                        $resultatstz = calculerResultatsClasse($request->classe, $request->section_id, $etablissement_section, $request->periode, $apprenantsSelect);
                        // dd($apprenantIds, $apprenantsSelect, $resultatstz);
                        foreach ($resultatstz as &$resultat) {
                            ajouterHistoriqueBulletin($resultat, $request->section_id, $exception);
                        }
                    }
                }
            }
        } else if ($request->section_id == 3) {
            $apprenant = 'étudiant';
            $section = 'Supérieure';
            $periode = Periode::where('type', "Semestre")->get();
            $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
            $cycle_filieres = DB::table('cycle_filieres')
                ->whereIn('filiere_id', $filieres->pluck('id'))
                ->get();
            if ($request->classe != null || $request->classe2 != null) {
                if ($request->tab == 'option-1') {
                    $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->where('statut', true)->get();
                    if ($request->session == 'Prémiere session') {
                        if ($historiqueBulletincheck->isEmpty()) {
                            $session = null;
                            $resultatsyy = calculerResultatsClasseSuperieure($request->classe, $request->section_id, $etablissement_section, $request->periode, $session);
                            if (empty($resultatsyy[0]['details_notes'])) {
                            } else {
                                foreach ($resultatsyy as $resultat) {
                                    ajouterHistoriqueBulletin($resultat, $request->section_id);
                                }
                            }
                        } else {
                            $resultats = HistoriqueBulletin::with('historique_notes')
                                ->where('classe_annee_id', $request->classe)
                                ->where('periode', Periode::where('id', $request->periode)->get()[0]->libelle)
                                ->where('statut', true)
                                ->get();
                        }
                    } else if ($request->session == 'Deuxiéme session') {
                        $session = true;
                        $notes_apprenant = getNoteByClasses($request->classe, $request->section_id, $request->periode, null, $session);
                        if ($notes_apprenant->isEmpty()) {
                        } else {
                            $historiqueBulletin = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('periode', Periode::find($request->periode)->libelle)->where('statut', true)->where('validation', 0)->get();
                            foreach ($historiqueBulletin as $apprenant_id) {
                                $apprenantIds = explode(',', $apprenant_id->apprenant_id);
                                $apprenantIds = array_map('trim', $apprenantIds);
                                $apprenantsSelect = Apprenant::whereIn('id', $apprenantIds)->get();
                                $resultatsyy = calculerResultatsClasseSuperieure($request->classe, $request->section_id, $etablissement_section, $request->periode, $apprenantsSelect, $session);
                                foreach ($resultatsyy as $resultat) {
                                    ajouterHistoriqueBulletin($resultat, $request->section_id);
                                }
                                $apprenant_id->statut = 0;
                                $apprenant_id->update();
                            }
                            $resultats = HistoriqueBulletin::with('historique_notes')
                                ->where('classe_annee_id', $request->classe)
                                ->where('periode', Periode::where('id', $request->periode)->get()[0]->libelle)
                                ->where('statut', true)
                                ->get();
                        }
                    }
                } elseif ($request->tab == 'option-2') {
                    $exception = true;
                    $apprenants = ClasseAnnee::with('apprenants')->find($request->classe)->apprenants()->get();
                    if ($request->session == 'Prémiere session') {
                        $session = null;
                    } else {
                        $session = true;
                    }
                    if ($request->apprenant != null) {
                        // Convertir la chaîne en tableau en utilisant la virgule comme délimiteur
                        $apprenantIds = explode(',', $request->apprenant);
                        // Supprimer les espaces autour de chaque ID
                        $apprenantIds = array_map('trim', $apprenantIds);
                        $apprenantsSelect = Apprenant::whereIn('id', $apprenantIds)->get();
                        foreach ($apprenantIds as $apprenantId) {
                            $historiqueBulletincheck = HistoriqueBulletin::where('classe_annee_id', $request->classe)->where('apprenant_id', $apprenantId)->where('periode', Periode::find($request->periode)->libelle)->get();
                            if ($historiqueBulletincheck->isEmpty()) {
                                $resultatstz = calculerResultatsClasseSuperieure($request->classe, $request->section_id, $etablissement_section, $request->periode, $apprenantsSelect, $session);
                                foreach ($resultatstz as $resultat) {
                                    ajouterHistoriqueBulletin($resultat, $request->section_id);
                                }
                                return $resultatstz;
                            } else {
                                $resultats = HistoriqueBulletin::with('historique_notes')
                                    ->where('classe_annee_id', $request->classe)
                                    ->where('periode', Periode::where('id', $request->periode)->get()[0]->libelle)
                                    ->where('statut', true)
                                    ->whereIn('apprenant_id', $apprenantIds)
                                    ->get();
                                return $resultats;
                            }
                        }
                    }
                }
            }
        }
        return Inertia::render('Rapport/Generation', [
            "sectionID" => $request->section_id,
            "resultats" => $resultats,
            "classes" => $classes,
            'periodes' => $periode,
            "filieres" => $filieres,
            "cycle_filieres" => $cycle_filieres,
            "apprenants" => $apprenants,
            'apprenant' => $apprenant,
            'premieregeneration' => $premieregeneration,
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

    private function handleSection1(Request $request, $etablissement_section)
    {
        // Logique spécifique à la section 1
    }
}
