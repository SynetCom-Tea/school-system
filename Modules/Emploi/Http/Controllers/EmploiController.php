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
    public function index()
    {
        // return view('emploi::index');
        $emplois = Emploi::with('seances.horaire')->get();
        dd($emplois);
        return Inertia::render('Emplois/Index', [
            'emplois' => $emplois
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $anneeScolaireId = Annee::find(2)->id;
        $etablissement = Etablissement::with('sections')->find(Auth::user()->etablissement_id);
        // Récupérer les IDs des sections
        $sectionIds = $etablissement->sections->pluck('id');
        // Récupérer les niveaux pour toutes les sections
        $sectionEtablissement = DB::table('etablissement_section')
        ->where('etablissement_id', Auth::user()->etablissement_id)
        ->whereIn('section_id', $sectionIds)
        ->pluck('id');
        $classeAnnees = ClasseAnnee::where('annee_id', $anneeScolaireId)->pluck('classe_id');
        $classes = Classe::whereIn('id', $classeAnnees)->whereIn('etablissement_section_id', $sectionEtablissement)->get();
        $niveaux = Niveau::whereIn('section_id', $sectionIds)->get();
        $matieres = Matiere::whereIn('etablissement_section_id', $sectionEtablissement)->get();
        $niveauMatiere = DB::table('niveau_matieres')
        ->whereIn('niveau_id', $niveaux->pluck('id'))
        ->whereIn('matiere_id', $matieres->pluck('id'))
        ->get();
        $salles = Salle::where('etablissement_id', Auth::user()->etablissement_id)->get();
        // $classes = $request->niveau ? DB::select("
        //     SELECT * FROM classes c
        //     JOIN classe_annees AS ca ON c.id = ca.classe_id
        //     JOIN annee_scolaires a ON a.id = ca.annee_scolaire_id
        //     JOIN enseignant_annees AS ea ON ca.id = ea.classe_annee_id
        //     JOIN niveau_matieres AS nm ON nm.id = ea.niveau_matiere_id
        //     WHERE a.id = :anneeScolaireId AND nm.niveau_id = :niveauId
        // ", [
        //     'anneeScolaireId' => $anneeScolaireId,
        //     'niveauId' => $request->niveau,
        // ]) : collect();
        // dd($sections->sections, $niveaux, $classes, $anneeScolaireId);
        return Inertia::render('Emplois/Create', [
            'sections' => $etablissement->sections,
            'niveaux' => $niveaux,
            'classes' => $classes,
            'sectionEtablissement' => $sectionEtablissement,
            'salles' => $salles,
            'matieres' => $matieres,
            'niveauMatiere' => $niveauMatiere
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
                        if ($seance['matiere'] != null){
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
                            ]);
                        }
                    }
                }
            }
        }
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
}
