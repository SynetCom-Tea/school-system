<?php

namespace Modules\Scolarite\Http\Controllers;

use App\Models\ApprenantClasseAnnee;
use App\Models\ApprenantTuteur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Tuteur;
use Illuminate\Support\Facades\Auth;

class TuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function listWarnings()
    {
        return Inertia::render('Tuteurs/ListWarnings', []);
    }
    public function meetings()
    {
        return Inertia::render('Tuteurs/Meetings', []);
    }
    public function mailBox()
    {
        return Inertia::render('Tuteurs/MailBox', []);
    }
    public function index()
    {
        $authUser = Auth::user();
        $vChildren = ApprenantTuteur::where('tuteur_id', (int) $authUser->tuteur_id)->with('apprenant')->get();
        $tabVChildren =
            $vChildren->map(function ($arg) {
                return
                    ApprenantClasseAnnee::whereHas(
                        'apprenant',
                        function ($query) use ($arg) {
                            $query->where('apprenant_id', (int)$arg->apprenant_id);
                        }
                    )->with('classe_annee', 'classe_annee.classe',  'classe_annee.classe.niveau', 'classe_annee.annee', 'apprenant')
                    ->get();
            });

        $Child =  $tabVChildren->map(
            function ($query) {
                return  $query->map(
                    function ($q) {

                        return [
                            "apprenant" => $q["apprenant"],
                            'annee' => $q["classe_annee"]["annee"],
                            'classe' => $q["classe_annee"]["classe"],
                        ];
                    }
                );
            }
        );
        $Children
            = $Child ? $Child[0] : [];

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
