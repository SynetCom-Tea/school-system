<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Annee;
use App\Models\ClasseAnnee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\NiveauMatiere;

class AffectationEnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $dernierId=Annee::max('id');
        $annee = Annee::where('id', $dernierId)->first();


        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $classes = DB::table('classes')
        ->join('classe_annees', 'classe_annees.classe_id', '=', 'classes.id')
        ->where('classe_annees.annee_id', '=', $annee->id)
        ->where('classes.etablissement_section_id', '=', $table->id)
        ->select('classes.libelle','classes.code','classe_annees.id')
        ->get();


        $enseignement_annee = DB::table('enseignement_annees as ea')
        ->join('enseignants as e', 'ea.enseignant_id', '=', 'e.id')
        ->join('niveau_matieres as nm', 'ea.niveau_matiere_id', '=', 'nm.id')
        ->join('classe_annees as ca', 'ea.classe_annee_id', '=', 'ca.id')
        ->join('classes as c', 'ca.classe_id', '=', 'c.id')
        ->join('niveaux as n', 'nm.niveau_id', '=', 'n.id')
        ->join('matieres as m', 'nm.matiere_id', '=', 'm.id')
        ->join('annees as a', 'ca.annee_id', '=', 'a.id')
        ->where('c.etablissement_section_id', $type)
        ->select('ea.id', 'e.NomComplet', 'c.libelle as classes', 'm.nom as matiere', 'a.libelle as annee')
        ->get();
        // dd($classes);
        $niveauMat = NiveauMatiere::with('matiere','niveau')->whereHas('matiere',function ($query) use ($table){

            $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){

            $query->where('section_id',$type);})->get();
        return Inertia::render('AffectationEnseignants/Index', [
            'niveauMatieres' => $niveauMat,
            'enseignants' => $enseignants,
            'classes'=>$classes,
            'enseignements'=>$enseignement_annee,
            'section_id' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('enseignement::create');
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
        return view('enseignement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('enseignement::edit');
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
