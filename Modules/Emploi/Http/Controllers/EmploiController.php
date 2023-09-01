<?php

namespace Modules\Emploi\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Etablissement;
use App\Models\Section;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Emploi\Entities\Emploi;
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
        return Inertia::render('Emplois/Index', [
            'emplois' => Emploi::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $anneeScolaireId = AnneeScolaire::find(1)->id;
        $sections = Etablissement::with('sections')->find(1);
        $niveaux = $request->section ? Niveau::where('section_id', $request->section)->get() : collect();
        $classes = $request->niveau ? DB::select("
            SELECT * FROM classes c
            JOIN classe_annees AS ca ON c.id = ca.classe_id
            JOIN annee_scolaires a ON a.id = ca.annee_scolaire_id
            JOIN enseignant_annees AS ea ON ca.id = ea.classe_annee_id
            JOIN niveau_matieres AS nm ON nm.id = ea.niveau_matiere_id
            WHERE a.id = :anneeScolaireId AND nm.niveau_id = :niveauId
        ", [
            'anneeScolaireId' => $anneeScolaireId,
            'niveauId' => $request->niveau,
        ]) : collect();
        // dd($sections->sections, $niveaux, $classes, $anneeScolaireId);
        return Inertia::render('Emplois/Create', [
            'sections' => $sections->sections,
            'niveaux' => $niveaux
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
