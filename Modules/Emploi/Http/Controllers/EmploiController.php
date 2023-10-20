<?php

namespace Modules\Emploi\Http\Controllers;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\Etablissement;
use App\Models\EtablissementSection;
use App\Models\Salle;
use App\Models\Section;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Emploi\Entities\Emploi;
use Modules\Emploi\Entities\Horaire;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\Niveau;

class EmploiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // dd('r:', $request->all());
        $classes = getClasses(Annee::find(2)->id, getSectionEtablissement($request->section_id, Auth::user()->etablissement_id), $request->section_id);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $events = [];
        $emplois = [];
        if ($request->classe != null) {
            $emplois = Emploi::getEmploisBySectionAndEtablissement($request->section_id, Auth::user()->etablissement_id, $request->classe);
            $seances = $request->emploi ? Emploi::getEmploiwhitClasse($request->classe, $request->emploi) : Emploi::getEmploiwhitClasse($request->classe);
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
        $etablissement = Etablissement::with('sections')->find(Auth::user()->etablissement_id);
        $etablissement_section = getSectionEtablissement($request->section_id, Auth::user()->etablissement_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $matieres = getMatieres($etablissement_section);
        $niveauMatiere = getNiveauxMatieres($matieres->pluck('id'),$niveaux->pluck('id'));
        $salles = Salle::where('etablissement_id', Auth::user()->etablissement_id)->get();
        // dd(Section::find($request->section_id));
        return Inertia::render('Emplois/Create', [
            'allSections' => $etablissement->sections,
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
        // dd($request->all());
        $dateDebut = Carbon::parse($request->date[0]);
        $dateFin = Carbon::parse($request->date[1]);
        $occurrences = countWeekdayOccurrences($dateDebut, $dateFin, $request->seances);
        // dd($occurrences);
        $classeAnnee = ClasseAnnee::where('annee_id', Annee::find(2)->id)
            ->where('classe_id', $request->classe)
            ->first();
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
        $etablissement_section = getSectionEtablissement($request->section_id, Auth::user()->etablissement_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $events = [];
        $emplois = [];
        if ($request->classe != null) {
            $emplois = Emploi::getEmploisBySectionAndEtablissement($request->section_id, Auth::user()->etablissement_id, $request->classe);
            $seances = $request->emploi ? Emploi::getEmploiwhitClasse($request->classe, $request->emploi) : Emploi::getEmploiwhitClasse($request->classe);
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
}
