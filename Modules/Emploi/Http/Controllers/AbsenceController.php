<?php

namespace Modules\Emploi\Http\Controllers;

use App\Models\Absence;
use App\Models\Annee;
use App\Models\Apprenant;
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
        $absencesAll = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        if($request->date){
            $seanceId = [];
            $apprenantIds = DB::table('apprenant_classe_annees')
            ->join('apprenants', 'apprenant_classe_annees.apprenant_id', '=', 'apprenants.id')
            ->where('apprenant_classe_annees.classe_annee_id', $request->classe)
            ->select('apprenants.id')
            ->get();
            dd(collect($apprenantIds)->pluck('id'));
            $absencesUneSeance = Absence::with('apprenant')->where('date', $request->date)->whereNotNull('seance_id')->whereIn('apprenant_id', collect($apprenantIds)->pluck('id'))->get();
            $absencesJourneeEntiere = Absence::with('apprenant')->where('date', $request->date)->whereNull('seance_id')->whereIn('apprenant_id', collect($apprenantIds)->pluck('id'))->get();
            // dd($absencesUneSeance);
            $seances = Emploi::getSeancesByIds($absencesUneSeance->pluck('seance_id'), $request->classe);
            $seancesById = collect($seances)->keyBy('id');
            $absencesJourneeEntiereAll = collect($absencesJourneeEntiere)->map(function ($absence) {
                $absenceData = [
                    'id' => $absence['id'],
                    'date' => $absence['date'],
                    'journee' => $absence['journee'],
                    'matricule_apprenant' => $absence['apprenant']['matricule'],
                    'nom_prenom_apprenant' => $absence['apprenant']['nom'] . ' - ' .$absence['apprenant']['prenom'],
                    'jour' => null,
                    'nom_matiere_heure_debut' => null,
                    'nom_prenom_enseignant' => null,
                    // Ajoutez d'autres champs de Absence que vous souhaitez inclure
                ];
                return $absenceData;
            });
            // Parcourir les absencesUneSeance et ajouter les informations de la séance correspondante
            $absencesJourneeAll = collect($absencesUneSeance)->map(function ($absence) use ($seancesById) {
                if ($absence['seance_id'] !== null) {
                    $seance = $seancesById->get($absence['seance_id']);
                    // Sélectionner spécifiquement quelques informations de Seance
                    $heureDebutSansSecondes = Carbon::parse($seance['heure_debut'])->format('H:i');
                    $heureFinSansSecondes = Carbon::parse($seance['heure_fin'])->format('H:i');
                    $seanceData = [
                        'jour' => $seance['jour'],
                        'nom_matiere_heure_debut' => $seance['nom_matiere'] . ' - ' . $heureDebutSansSecondes . ' à ' . $heureFinSansSecondes,
                        'nom_prenom_enseignant' => $seance['enseignant_nom'] . ' - ' . $seance['enseignant_prenom'],
                        // Ajoutez d'autres champs de Seance que vous souhaitez inclure
                    ];
                
                    // Sélectionner spécifiquement quelques informations de Absence
                    $absenceData = [
                        'id' => $absence['id'],
                        'date' => $absence['date'],
                        'journee' => $absence['journee'],
                        'matricule_apprenant' => $absence['apprenant']['matricule'],
                        'nom_prenom_apprenant' => $absence['apprenant']['nom'] . ' - ' .$absence['apprenant']['prenom']
                        // Ajoutez d'autres champs de Absence que vous souhaitez inclure
                    ];
                
                    // Fusionner les informations sélectionnées de Seance avec Absence
                    return array_merge($absenceData, $seanceData);
                }
                
            });
            $absencesAll = array_merge($absencesJourneeEntiereAll->toArray(), $absencesJourneeAll->toArray());
            // dd($absencesUneSeance, $absencesJourneeEntiere, $absencesJourneeAll->toArray(), $absencesJourneeEntiereAll, $absencesJourneeAll, $absencesAll);
        }
        return Inertia::render('Absence/Index', [
            'absencesAll' => $absencesAll,
            'AllClasses' => $classes,
            'niveaux' => $niveaux,
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
        $filiere_niveau_matiere_ues = [];
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $classes = getClasses(Annee::find(2)->id, $etablissement_section);
        $niveaux = Niveau::where('section_id', $request->section_id)->get();
        $filieres = Filiere::whereIn('etablissement_section_id', $etablissement_section)->get();
        $cycle_filieres = DB::table('cycle_filieres')
                ->whereIn('filiere_id', $filieres->pluck('id'))
                ->get();
        $cycles = Cycle::whereIn('id', $cycle_filieres->pluck('cycle_id'))->get();
        if($request->section_id == 1 || $request->section_id == 2){
            
        }elseif($request->section_id == 3 || $request->section_id == 4){
            // dd($filieres, $etablissement_section, Auth::user()->etablissement_id, $request->section_id);
            $filiere_niveau_matiere_ues = DB::table('filiere_niveau_matiere_ues')
                ->whereIn('cycle_filiere_id', $cycle_filieres->pluck('id'))->get();
        }
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
            $seancesMapped = $seancesMapped->values();
            $apprenantsMapped = $apprenants->map(function ($apprenant) {
                $apprenant->nom_prenom = $apprenant->nom . ' - ' . $apprenant->prenom;
            
                return $apprenant;
            });
            // dd($seancesMapped);
        }
        return Inertia::render('Absence/Create', [
            'filiere_niveau_matiere_ues' => $filiere_niveau_matiere_ues,
            'props_cycles' => $cycles,
            'filieres' => $filieres,
            'cycle_filieres' => $cycle_filieres,
            'niveauxSe' => $niveaux,
            'classes' => $classes,
            'apprenants' => $apprenantsMapped,
            'seances_mapped' => $seancesMapped,
            'sectionEnquestion' => Section::find($request->section_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        foreach($request->absences as $absence){
            // Vérifier si seance_id est défini
            $seanceId = isset($absence['seance']) ? $absence['seance'] : null;

            // Créer un tableau avec les valeurs à insérer
            $absenceData = [
                'apprenant_id' => $absence['apprenant'],
                'journee' => $absence['ensalle'],
                'date' => now()->toDateString()
            ];

            // Ajouter seance_id au tableau si défini
            if ($seanceId !== null) {
                $absenceData['seance_id'] = $seanceId;
            }

            // Créer l'enregistrement d'absence
            Absence::create($absenceData);
        }
        return redirect()->route('absences.index', $request->section)->with('message', [
            'type' => 'success',
            'text' => "Les absences ont été ajouter avec succès !",
        ]);
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
