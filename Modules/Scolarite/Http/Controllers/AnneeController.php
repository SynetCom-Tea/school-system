<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\AnneeScolaire;

class AnneeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Annee/Index', [
            'annees' => AnneeScolaire::all()
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
            'annee' => 'required|string',
        ]);
        AnneeScolaire::create($request->all());
        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "L'année a été créée avec succès !",
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
        return Inertia::render('Annee/Edit', [
            'annee' => AnneeScolaire::find($id)
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
        $annee = AnneeScolaire::find($id);
        $annee->update($request->all());
        return redirect()->route('annees.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try{
            $annee = AnneeScolaire::find($id);
            $annee->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('annees.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette année!",
                ]);

            }
        }
        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "L'année a été supprimée avec succès !",
        ]);
    }
}
