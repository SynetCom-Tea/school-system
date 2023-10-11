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
use Modules\Enseignement\Entities\EnseignementAnnee;
use Modules\Enseignement\Entities\Matiere;
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


        $classes = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->whereHas('annee',function($anne) use ($annee){
            $anne->where('annee_id',$annee->id);
        })->get();

        // dd($classes);
        $enseignement_annee=EnseignementAnnee::whereHas('classe_annee.classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->with('niveau_matiere.matiere','classe_annee.classe','classe_annee.annee','enseignant')->get();

        // dd( $enseignement_annee);
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
    public function create($type)
    {
        $dernierId=Annee::max('id');
        $annee = Annee::where('id', $dernierId)->first();
        $ets_id = Auth::user()->etablissement_id;
        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $classes = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->whereHas('annee',function($anne) use ($annee){
            $anne->where('annee_id',$annee->id);
        })->get();
        return Inertia::render('AffectationEnseignants/Create', [
            'section_id' => $type,
            'classes'=>$classes,
            'enseignants' => $enseignants,
            'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
        ]);
        // return view('enseignement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$type)
    {
        //
        // dd($request);
        // $ets_id = Auth::user()->etablissement_id;

        // foreach($request->donnees as $donnee){
        //     foreach($request->donnees as $donnee){

        //     }
        // }
        return redirect()->back();
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
