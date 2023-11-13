<?php

namespace Modules\Emploi\Http\Controllers;

use App\Models\Absence;
use App\Models\Annee;
use App\Models\ApprenantClasseAnnee;
use App\Models\ClasseAnnee;
use App\Models\Cycle;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Emploi\Entities\Emploi;
use Modules\Enseignement\Entities\Filiere;
use Modules\Enseignement\Entities\Niveau;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $apprenants = ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request,$annee) { 
        //     $query->where('classe_id',$request->classe)->where('annee_id',$annee); 
        // })->with('apprenant')->get();
        return Inertia::render('Absence/Index', [
            'absences' => [],
            'sectionID' => $request->section_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $seancesMapped = [];
        $apprenantsMapped = [];
        $apprenants = [];
        $seancesDuJour = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
        $cycle_filieres = DB::table('cycle_filieres')
                ->whereIn('filiere_id', $filieres->pluck('id'))
                ->get();
        $cycles = Cycle::whereIn('id', $cycle_filieres->pluck('cycle_id'))->get();
        if ($request->classe != null) {
            $apprenants = DB::table('apprenant_classe_annees')
            ->join('apprenants', 'apprenant_classe_annees.apprenant_id', '=', 'apprenants.id')
            ->where('apprenant_classe_annees.classe_annee_id', $request->classe)
            ->select('apprenants.*')
            ->get();
            $seances = Emploi::getEmploiwhitClasse($request->section_id, $request->classe);

            // Filtrer les séances du jour
            $seancesDuJour = collect($seances)->filter(function ($seance) {
                $today = now(); // Obtient la date actuelle
                $dateDebut = Carbon::parse($seance->date_debut);
                $dateFin = Carbon::parse($seance->date_fin);

                // Vérifie si la date du jour est comprise entre date_debut et date_fin
                $dateDuJour = $today->between($dateDebut, $dateFin);

                // Vérifie si le jour de la séance est le même que le jour actuel
                $jourDuJour = ucfirst(strtolower($today->dayName)) === ucfirst(strtolower($seance->jour));

                // Retourne vrai si les deux conditions sont remplies
                return $dateDuJour && $jourDuJour;
            });
            $seancesMapped = $seancesDuJour->map(function ($seance) {
                // Obtient l'heure de début sans les secondes
                $heureDebutSansSecondes = Carbon::parse($seance->heure_debut)->format('H:i');
                $heureFinSansSecondes = Carbon::parse($seance->heure_fin)->format('H:i');
            
                // Concatène nom_matiere avec heure_debut sans les secondes
                $seance->nom_matiere_heure_debut = $seance->nom_matiere . ' - ' . $heureDebutSansSecondes . ' à ' . $heureFinSansSecondes;
            
                return $seance;
            });
            $apprenantsMapped = $apprenants->map(function ($apprenant) {
                $apprenant->nom_prenom = $apprenant->nom . ' - ' . $apprenant->prenom;
            
                return $apprenant;
            });
            // dd($apprenants, $seancesDuJour, $seancesMapped);
        }
        return Inertia::render('Absence/Create', [
            'props_cycles' => $cycles,
            'filieres' => $filieres,
            'cycle_filieres' => $cycle_filieres,
            'niveaux' => $niveaux,
            'classes' => $classes,
            'apprenants' => $apprenantsMapped,
            'seancesMapped' => $seancesMapped,
            'sectionEnquestion' => Section::find($request->section_id)
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
    public function show(Absence $absence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $absence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $absence)
    {
        //
    }
}
