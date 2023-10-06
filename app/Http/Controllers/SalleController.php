<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ets_id = Auth::user()->etablissement_id;
        return Inertia::render('Salles/Index', [
            'salles' => Salle::where('etablissement_id',$ets_id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Salles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ets_id = Auth::user()->etablissement_id;
        foreach($request->donnees as $donnee){
            
                Salle::updateOrInsert([
                    'libelle' => $donnee['libelle']
                ],
                [
                'code' => $donnee['code'],
                'etablissement_id' => $ets_id
                ]
                );
            
        }
        
        return redirect()->route('salles.index')->with('message', [
            'type' => 'success',
            'text' => "La salle a été créée avec succès !",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Salle $salle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salle $salle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salle = Salle::find($id);
        $salle->update($request->all());
        return redirect()->route('salles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $salle = Salle::find($id);
            $salle->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->route('salles.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette salle!",
                ]);

            }
        }
        return redirect()->route('salles.index')->with('message', [
            'type' => 'success',
            'text' => "La salle a été supprimée avec succès !",
        ]);
    }
}
