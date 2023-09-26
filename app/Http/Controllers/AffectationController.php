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
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->first();
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
    public function create()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
