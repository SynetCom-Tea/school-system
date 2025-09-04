<?php

namespace Modules\Emploi\Http\Controllers;

use DateTime;
use DateInterval;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Cycle;
use App\Models\Salle;
use App\Models\Classe;
use App\Models\Section;
use App\Models\ClasseAnnee;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Emploi\Entities\Emploi;
use App\Models\ApprenantClasseAnnee;
use App\Models\EtablissementSection;
use Illuminate\Support\Facades\Auth;
use Modules\Emploi\Entities\Horaire;
use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Filiere;
use Modules\Enseignement\Entities\Matiere;
use Illuminate\Contracts\Support\Renderable;

class EmploiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // dd('r:', $request->all());
        $annee = Annee::where('actif',1)->first();
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
       
        $classes = getClasses($annee->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        // dd($classes);
        $events = [];
        $emplois = [];
        if ($request->classe != null) {
            $emplois = Emploi::getEmploisBySectionAndEtablissement($request->section_id, Auth::user()->etablissement_id, $request->classe);
            $seances = $request->emploi ? Emploi::getEmploiwhitClasse($request->section_id, $request->classe, $request->emploi) : Emploi::getEmploiwhitClasse($request->section_id, $request->classe);
            foreach ($seances as $seance) {
                // Extraire les heures et les minutes de heure_debut et heure_fin
                $heureDebut = substr($seance->heure_debut, 0, 5);  // HH:MM
                $heureFin = substr($seance->heure_fin, 0, 5);  // HH:MM
                $event = [
                    'title' => $seance->nom_matiere,
                    'with' => $seance->enseignant_nom . ' ' . $seance->enseignant_prenom,
                    'time' => [
                        'start' => $seance->date_seance . ' ' . $heureDebut,
                        'end' => $seance->date_seance . ' ' . $heureFin
                    ],
                    'isEditable' => true,
                    'id' => uniqid(), // Générer un identifiant unique pour l'événement
                    'colorScheme' => 'meetings',
                ];
                $events[] = $event;
            }
            // dd($events);
        }
        return Inertia::render('Emplois/Index', [
            'emplois' => $emplois,
            'AllClasses' => $classes,
            'niveaux' => $niveaux,
            'events' => $events,
            'sectionID' => $request->section_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $matieres = getMatieres($etablissement_section);
        $annee = Annee::where('actif',1)->first();
        $classes = getClasses($annee->id, $etablissement_section);
        $niveauMatiere = [];
        $filiere_niveau_matiere_ues = [];
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
        $cycle_filieres = DB::table('cycle_filieres')
                ->whereIn('filiere_id', $filieres->pluck('id'))
                ->get();
        $cycles = Cycle::whereIn('id', $cycle_filieres->pluck('cycle_id'))->get();
        if($request->section_id == 1 || $request->section_id == 2){
            $niveauMatiere = getNiveauxMatieres($matieres->pluck('id'),$niveaux->pluck('id'));
        }elseif($request->section_id == 3 || $request->section_id == 4){
            // dd($filieres, $etablissement_section, Auth::user()->etablissement_id, $request->section_id);
            $filiere_niveau_matiere_ues = DB::table('filiere_niveau_matiere_ues')
                ->whereIn('cycle_filiere_id', $cycle_filieres->pluck('id'))->get();
        }
        $salles = Salle::where('etablissement_id', Auth::user()->etablissement_id)->get();
        // dd($filieres, $cycle_filieres, $niveaux);
        return Inertia::render('Emplois/Create', [
            'filiere_niveau_matiere_ues' => $filiere_niveau_matiere_ues,
            'props_cycles' => $cycles,
            'filieres' => $filieres,
            'cycle_filieres' => $cycle_filieres,
            'niveaux' => $niveaux,
            'classes' => $classes,
            'salles' => $salles,
            'matieres' => $matieres,
            'niveauMatiere' => $niveauMatiere,
            'sectionEnquestion' => Section::find($request->section_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
   {
    // Validation des données
    $validated = $request->validate([
        'date' => 'required|array|size:2',
        'date.0' => 'required|date',
        'date.1' => 'required|date|after_or_equal:date.0',
        'section' => 'required|exists:sections,id',
        'classe' => 'required|exists:classe_annees,id',
        'seances' => 'required|array'
    ]);

    $dateDebut = Carbon::parse($request->date[0]);
    $dateFin = Carbon::parse($request->date[1]);
    $occurrences = countWeekdayOccurrences($dateDebut, $dateFin, $request->seances);
    
    // Récupérer directement la classe_annee
    $classeAnnee = ClasseAnnee::find($request->classe);
    
    if (!$classeAnnee) {
        return redirect()->back()
            ->withErrors(['classe' => 'La classe sélectionnée n\'existe pas.'])
            ->withInput();
    }

    // Vérifier que la classe appartient à la bonne section
    $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section);
    $isValid = $classeAnnee->classe->etablissement_section_id == $etablissement_section->first();
    
    if (!$isValid) {
        return redirect()->back()
            ->withErrors(['classe' => 'La classe ne fait pas partie de la section sélectionnée.'])
            ->withInput();
    }

    // Utiliser $classeAnnee pour la suite
    try {
        DB::beginTransaction();
        $emploi = Emploi::create([
            'date_debut' => $request->date[0],
            'date_fin' => $request->date[1],
            'classe_annee_id' => $request->classe
        ]);
            foreach ($occurrences as $jour => $seancesDuJour) {
                // Vérifie s'il y a des horaires pour ce jour
                if (count($seancesDuJour['seances']) > 0 && $seancesDuJour['seances'][0]['matiere'] != null) {

                    // dd($jour, $seancesDuJour['seances'], $occurrences['Lundi']);
                    // Récupère les horaires pour ce jour
                    foreach ($seancesDuJour['seances'] as $seance) {
                        // dd($seance);
                        // for ($i = 0; $i < $seancesDuJour['occurrences']; $i++) {
                            if ($seance['matiere'] != null) {
                                // $dateSeance = (new DateTime($seancesDuJour['date_debut']))->add(new DateInterval('P' . ($i * 7) . 'D'));
                                // Vérifiez si $seance['salle'] existe
                                if (isset($seance['salle'])) {
                                    $salleId = $seance['salle'];
                                } else {
                                    $salleId = null;
                                }
                                // Variable pour stocker la clé dynamique en fonction de $request->section
                                $key = '';
                                if ($request->section == 1 || $request->section == 2) {
                                    $key = 'niveau_matiere_id';
                                } elseif ($request->section == 3 || $request->section == 4) {
                                    $key = 'filiere_niveau_matiere_ue_id';
                                }
                                Horaire::create([
                                    'heure_debut' => sprintf('%02d:%02d:%02d', $seance['horaire'][0]['hours'], $seance['horaire'][0]['minutes'], $seance['horaire'][0]['seconds']),
                                    'heure_fin' => sprintf('%02d:%02d:%02d', $seance['horaire'][1]['hours'], $seance['horaire'][1]['minutes'], $seance['horaire'][1]['seconds'])
                                ])->seances()->create([
                                    'statut' => false,
                                    $key => ($request->section == 1 || $request->section == 2)
                                    ? DB::table('niveau_matieres')
                                        ->where('niveau_id', $request->niveau)
                                        ->where('matiere_id', $seance['matiere'])
                                        ->first()->id
                                    : DB::table('filiere_niveau_matiere_ues')
                                        ->where('niveau_id', $classe->niveau_id)
                                        ->where('matiere_id', $seance['matiere'])
                                        ->first()->id,
                                    'emploi_id' => $emploi->id,
                                    'salle_id' => $salleId,
                                    'jour' => $jour,
                                    'heure_debut' => sprintf('%02d:%02d:%02d', $seance['horaire'][0]['hours'], $seance['horaire'][0]['minutes'], $seance['horaire'][0]['seconds']),
                                    'heure_fin' => sprintf('%02d:%02d:%02d', $seance['horaire'][1]['hours'], $seance['horaire'][1]['minutes'], $seance['horaire'][1]['seconds'])
                                ]);
                            }
                        // }
                    }
                }
            }
        }catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
        DB::commit();
        return redirect()->route('emplois.index', ['section_id' => $request->section])->with('message', [
            'type' => 'success',
            'text' => "Emploi ajouté avec succès!",
        ]);
        // die();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('emploi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('emploi::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function calendar(Request $request)
    {
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $annee = Annee::where('actif',1)->first();
        $classes = getClasses($annee->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $resultats = [];
        $emplois = [];
        $events = [];
        $emploiUnique = null;
        if ($request->classe != null) {
            $emplois = Emploi::getEmploisBySectionAndEtablissement($request->section_id, Auth::user()->etablissement_id, $request->classe);
            $seances = $request->emploi ? Emploi::getEmploiwhitClasse($request->section_id, $request->classe, $request->emploi) : Emploi::getEmploiwhitClasse($request->section_id, $request->classe);
            if($request->emploi != null){
                $emploiUnique = Emploi::find($request->emploi);
            }else{
                // CORRECTION : Vérifier si le tableau n'est pas vide avant d'accéder à l'index 0
                $emploiUnique = !empty($emplois) ? $emplois[0] : null;
            }
            // Add additional validation before using $emploiUnique
            if (!$emploiUnique) {
                // Handle the case where no emploi is found
                return back()->with('error', 'Aucun emploi du temps trouvé pour cette classe');
            }
            $dateDebut = Carbon::parse($emploiUnique->date_debut);
            $dateFin = Carbon::parse($emploiUnique->date_fin);
            $resultats = generationCalendar($dateDebut, $dateFin, $seances);
            // Vérification de la clé 'events' dans $resultats
            if (isset($resultats['events'])) {
                $events = $resultats['events'];
            } else {
                $events = [];
            }
            // dd($events);
            // dd($events[1],$events[567],$events[500],$events[2],$events[4],$events[300],$events[200],$events[124]);
        }
        // if($request->emploi != null){
        //     dd(Emploi::getEmploiwhitClasse($request->classe, $request->emploi));
        // }
        return Inertia::render('Emplois/Calendar', [
            'emplois' => $emplois,
            'AllClasses' => $classes,
            'niveaux' => $niveaux,
            'events' => $events,
            'sectionID' => $request->section_id
        ]);
    }
    public function MonEmploi(Request $request){
        $user = Auth::user();
        $events = [];
        $classe_anne_id = ApprenantClasseAnnee::where('apprenant_id',$user->apprenant_id)->get()[0]->classe_annee_id;
        // dd($classe_anne_id);
        $emplois = Emploi::getEmploisBySectionAndEtablissement(3, $user->etablissement_id, $classe_anne_id);
        // dd($emplois);
        $seances = $request->emploi ? Emploi::getEmploiwhitClasse(3, $classe_anne_id, $request->emploi) : Emploi::getEmploiwhitClasse(3, $classe_anne_id);
        // dd($seances);
        foreach ($seances as $seance) {
            $heureDebut = substr($seance->heure_debut, 0, 5);  
            $heureFin = substr($seance->heure_fin, 0, 5);  
            $event = [
                'title' => $seance->nom_matiere,
                'with' => $seance->enseignant_nom . ' ' . $seance->enseignant_prenom,
                'time' => [
                    'start' => $seance->date_seance . ' ' . $heureDebut,
                    'end' => $seance->date_seance . ' ' . $heureFin
                ],
                'isEditable' => true,
                'id' => uniqid(), 
                'colorScheme' => 'meetings',
            ];
            $events[] = $event;
        }
        // dd($events);
        return Inertia::render('Emplois/MonEmploi',[
            'emplois'=> $emplois,
            'seances' => $events
        ]);
    }
}
