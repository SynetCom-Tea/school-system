<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\Matiere;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        return Inertia::render('Matieres/Index', [
            'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
            'section_id' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        return Inertia::render('Matieres/Create', [
            'section_id' => $type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        // dd($request);
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();



            Matiere::updateOrInsert([
                'nom' => $request->nom,
                'etablissement_section_id' => $table->id,
            ],
            [

            ]
            );



        return redirect()->route('matieres.index', $type)->with('message', [
            'type' => 'success',
            'text' => "Les matières ont été créées avec succès !",
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
        $matiere = Matiere::find($id);
        $matiere->update($request->all());
        $table = DB::table('etablissement_section')->where('id',$matiere->etablissement_section_id)->first();
        return redirect()->route('matieres.index', $table->section_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $matiere = Matiere::find($id);
            $table = DB::table('etablissement_section')->where('id',$matiere->etablissement_section_id)->first();
            $matiere->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('matieres.index', $table->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette matière!",
                ]);

            }
        }
        return redirect()->route('matieres.index', $table->section_id)->with('message', [
            'type' => 'success',
            'text' => "La matière a été supprimée avec succès !",
        ]);
    }
}
