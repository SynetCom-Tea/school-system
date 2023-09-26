<?php

namespace Modules\Emploi\Http\Controllers;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\Etablissement;
use App\Models\EtablissementSection;
use App\Models\Salle;
use App\Models\Section;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Emploi\Entities\Emploi;
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
        $matieres = DB::table('niveau_matieres')
            ->where('etablissement_id', Auth::user()->etablissement_id)
            ->whereIn('section_id', $sectionIds)
            ->pluck('id');
        Matiere::whereIn('etablissement_section_id', $sectionEtablissement)->get();
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
            'matieres' => $matieres
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
