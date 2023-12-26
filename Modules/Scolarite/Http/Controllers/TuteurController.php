<?php

namespace Modules\Scolarite\Http\Controllers;

use App\Models\Absence;
use App\Models\ApprenantClasseAnnee;
use App\Models\ApprenantTuteur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Tuteur;
use Illuminate\Support\Facades\Auth;
use Modules\Emploi\Entities\Emploi;

class TuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function listWarnings()
    {
        $authUser = Auth::user();
        $vChildren = ApprenantTuteur::where('tuteur_id', (int) $authUser->tuteur_id)->with('apprenant')->get();
        $absences = Absence::whereIn('apprenant_id', $vChildren->pluck('apprenant')->pluck('id'))->get();
        $absencesUneSeance = Absence::with('apprenant')->whereNotNull('seance_id')->whereIn('apprenant_id', $vChildren->pluck('apprenant')->pluck('id'))->get();
        $absencesJourneeEntiere = Absence::with('apprenant')->whereNull('seance_id')->whereIn('apprenant_id', $vChildren->pluck('apprenant')->pluck('id'))->get();
        $seances = Emploi::getSeancesByIds($absencesUneSeance->pluck('seance_id'));
        $seancesById = collect($seances)->keyBy('id');
        $absencesJourneeEntiereAll = collect($absencesJourneeEntiere)->map(function ($absence) {
            $absenceData = [
                'id' => $absence['id'],
                'date' => Carbon::parse($absence['date'])->locale('fr_FR')->isoFormat('dddd D MMMM YYYY'),
                'journee' => $absence['journee'],
                'nom_complet' => $absence['apprenant']['matricule'] . ' - ' . $absence['apprenant']['nom'] . '  ' .$absence['apprenant']['prenom'],
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
                    'date' => Carbon::parse($absence['date'])->locale('fr_FR')->isoFormat('dddd D MMMM YYYY'),
                    'journee' => $absence['journee'],
                    'nom_complet' => $absence['apprenant']['matricule'] . ' - ' . $absence['apprenant']['nom'] . '  ' .$absence['apprenant']['prenom'],
                    // Ajoutez d'autres champs de Absence que vous souhaitez inclure
                ];
            
                // Fusionner les informations sélectionnées de Seance avec Absence
                return array_merge($absenceData, $seanceData);
            }
            
        });
        $absencesAll = array_merge($absencesJourneeEntiereAll->toArray(), $absencesJourneeAll->toArray());
        // dd($authUser->tuteur_id, $absencesAll);
        return Inertia::render('Tuteurs/ListWarnings', [
            'absencesAll' => $absencesAll
        ]);
    }
    public function meetings()
    {
        return Inertia::render('Tuteurs/Meetings', []);
    }
    public function dashboard()
    {
        return Inertia::render('Tuteurs/Dashboard', []);
    }
    public function result()
    {
        return Inertia::render('Tuteurs/Result', []);
    }
    public function mailBox()
    {
        return Inertia::render('Tuteurs/MailBox', []);
    }
    public function index()
    {
        $authUser = Auth::user();
        $vChildren = ApprenantTuteur::where('tuteur_id', (int) $authUser->tuteur_id)->with('apprenant')->get();

        $tabVChildren = $vChildren->map(function ($arg) {
            return ApprenantClasseAnnee::whereHas(
                'apprenant',
                function ($query) use ($arg) {
                    $query->where('apprenant_id', (int)$arg->apprenant_id);
                }
            )->with('classe_annee', 'classe_annee.classe',  'classe_annee.classe.niveau', 'classe_annee.annee', 'apprenant')
            ->get();
        });

        $Child = $tabVChildren->map(function ($query) {
            return $query->map(function ($q) {
                return [
                    "apprenant" => $q["apprenant"],
                    'annee' => $q["classe_annee"]["annee"],
                    'classe' => $q["classe_annee"]["classe"],
                ];
            });
        });
        $Children = $Child->flatten(1);
            // dd($Children);
        return Inertia::render('Tuteurs/ListChildren', [
            'children' => $Children
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        request()->validate([
            'nom1' => 'required|string',
            'tel1' => 'required|string',
            'nom2' => 'required|string',
            'tel2' => 'required|string',
        ]);
        Tuteur::create($request->all());
        return redirect()->route('tuteurs.index')->with('message', [
            'type' => 'success',
            'text' => "Le tuteur a été créé avec succès !",
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return Inertia::render('Tuteur/Edit', [
            'tuteur' => Tuteur::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $tuteur = Tuteur::find($id);
        $tuteur->update($request->all());
        return redirect()->route('tuteurs.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $tuteur = Tuteur::find($id);
            $tuteur->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                //dd($e->getCode());
                return redirect()->route('tuteurs.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer ce tuteur!",
                ]);
            }
        }
        return redirect()->route('tuteurs.index')->with('message', [
            'type' => 'success',
            'text' => "Le tuteur a été supprimé avec succès !",
        ]);
    }
}
