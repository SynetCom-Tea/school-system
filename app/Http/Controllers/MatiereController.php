<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Matiere;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Matieres/Index', [
            'matieres' => Matiere::all()
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
        request()->validate([
            'code' => 'required|string',
            'libele' => 'required|string',
        ]);
        Matiere::create($request->all());
        return redirect()->route('matieres.index')->with('message', [
            'type' => 'success',
            'text' => "La matière a été créée avec succès !",
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
        return Inertia::render('Matiere/Edit', [
            'matiere' => Matiere::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $matiere = Matiere::find($id);
        $matiere->update($request->all());
        return redirect()->route('matieres.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $matiere = Matiere::find($id);
            $matiere->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('matieres.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette matière!",
                ]);

            }
        }
        return redirect()->route('matieres.index')->with('message', [
            'type' => 'success',
            'text' => "La matière a été supprimée avec succès !",
        ]);
    }
}
