<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Tuteur;

class TuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Tuteur/Index', [
            'tuteurs' => Tuteur::all()
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
        try{
            $tuteur = Tuteur::find($id);
            $tuteur->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
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
