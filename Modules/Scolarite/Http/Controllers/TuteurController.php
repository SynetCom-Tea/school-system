<?php

namespace Modules\Scolarite\Http\Controllers;

use App\Models\Absence;
use App\Models\ApprenantClasseAnnee;
use App\Models\ApprenantTuteur;
use App\Models\HistoriqueBulletin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Tuteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Emploi\Entities\Emploi;
use Modules\GestionNote\Entities\Evaluation;
use Modules\GestionNote\Entities\TypeEvaluation;

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
        $childrenID = $vChildren->pluck('apprenant_id')->all();
        $absencesAll = getAbsenceOfTuteurChildren($childrenID);
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
    public function result(Request $request)
    {
        // // Exemple d'utilisation
        // // Exemple d'utilisation :
        // $donnees = [
        //     ['nom' => 'Alice', 'score' => 90],
        //     ['nom' => 'Bob', 'score' => 85],
        //     ['nom' => 'Charlie', 'score' => 90],
        //     ['nom' => 'David', 'score' => 78],
        // ];

        // $rangs = calculerRangs($donnees);
        // dd($rangs);
        $resultatsFinauxQuery = [];
        $bulletinsChild = [];
        $graphData = [];
        $authUser = Auth::user();
        $vChildren = ApprenantTuteur::where('tuteur_id', (int) $authUser->tuteur_id)->with('apprenant')->get();
        $vChildren->map(function ($item) {
            $item->apprenant->full_name = $item->apprenant->matricule . ' ' . $item->apprenant->nom . ' ' . $item->apprenant->prenom;
            return $item;
        });
        if($request->apprenant){
            $childrenID = $vChildren->where('apprenant_id', $request->apprenant)->pluck('apprenant_id')->all();
            $resultatsFinauxQuery = getNoteTuteurChildren($childrenID, $request->type_evaluation);
            // dd($resultatsFinauxQuery);
            $bulletinsChild = HistoriqueBulletin::with('historique_notes')->whereIn('apprenant_id', $childrenID)->get();
            // dd($resultatsFinauxQuery, $bulletinsChild);
        }
        if (!empty($resultatsFinauxQuery)){
            $resultatsFinauxQuery = $resultatsFinauxQuery[0]['evaluations'];
            // Organiser les résultats pour faciliter la création du graphe
            $graphData = [];

            foreach ($resultatsFinauxQuery as $evaluation) {
                // dd($evaluation['matiere']);
                $graphData[$evaluation['matiere']['id_matiere']][$evaluation['periode_evaluation']][] = [
                    'id_evaluation' => $evaluation['id_evaluation'],
                    'note' => $evaluation['note_obtenue'],
                    'date' => $evaluation['date_evaluation'],
                    'matiere' => $evaluation['matiere']['nom_matiere'],
                ];
            }
            // dd($resultatsFinauxQuery, $graphData);
        }
        // dd($resultatsFinauxQuery, $bulletinsChildren, $vChildren->pluck('apprenant'));
        return Inertia::render('Tuteurs/Result', [
            'resultatsFinauxQuery' => $resultatsFinauxQuery,
            'children' => $vChildren->pluck('apprenant'),
            'typeEvaluations' => TypeEvaluation::all(),
            'bulletinsChild' => $bulletinsChild,
            "graphData" => $graphData
        ]);
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
