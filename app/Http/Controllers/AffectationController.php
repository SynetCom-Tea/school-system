<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\NiveauMatiere;

class AffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $niveauMat = NiveauMatiere::with('matiere','niveau')->whereHas('matiere',function ($query) use ($table){

            $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){

            $query->where('section_id',$type);})->get();

        return Inertia::render('AffectationNiveauMatiere/Index', [
            'niveauMatieres' => $niveauMat,
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        return Inertia::render('AffectationNiveauMatiere/Create', [
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        // dd($request);
        foreach($request->Affectations as $Affectation){
        foreach($Affectation['niveau_id'] as $niv){
            NiveauMatiere::updateOrInsert([
                'matiere_id' => $Affectation['matiere_id'],
                'niveau_id' => $niv
            ],
            ['volume_horaire' => $Affectation['volume_horaire'],
            'coefficient' => $Affectation['coefficient']]
        );
        }
    }
        return redirect()->route('affectations.index', $type)->with('message', [
            'type' => 'success',
            'text' => "La matière a été affectée aux niveaux avec succès !",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $aff = NiveauMatiere::find($id);
        $aff->update($request->all());
        $table = Niveau::where('id',$aff->niveau_id)->first();
        return redirect()->route('affectations.index', $table->section_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $aff = NiveauMatiere::find($id);
            $table = Niveau::where('id',$aff->niveau_id)->first();
            $aff->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('affectations.index',$table->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer la matière de ce niveau!",
                ]);

            }
        }
        return redirect()->route('affectations.index',$table->section_id)->with('message', [
            'type' => 'success',
            'text' => "La matière a été supprimée de ce niveau avec succès !",
        ]);
    }
}
