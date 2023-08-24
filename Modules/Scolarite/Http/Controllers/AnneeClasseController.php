<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Annee;
use Modules\Scolarite\Entities\Classe;
use Modules\Scolarite\Entities\AnneeClasse;

class AnneeClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Promotion/Index', [
            'promotions' => AnneeClasse::with('annees', 'classes')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return Inertia::render('Promotion/Create', [
            'annees' => Annee::all(),
            'classes' => Classe::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        foreach($request->classes as $classe){
            AnneeClasse::create([
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'annee_id' => $request->annee_id,
                'classe_id' => $classe['classe_id'],
            ]);
        }
        return redirect()->route('promotions.index')->with('message', [
            'type' => 'success',
            'text' => "La promotion a été créée avec succès !",
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
        return Inertia::render('Promotion/Edit', [
            'annees' => Annee::all(),
            'classes' => Classe::all()
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
