<?php

namespace App\Http\Controllers;

use App\Models\ChefEtablissement;
use App\Models\EtablissementSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChefEtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chefs = ChefEtablissement::with('etablissementSection.section')->get();
        $etablissementSections = EtablissementSection::with('section')->get();

        return Inertia::render('ChefEtablissement/Index', [
            'chefs' => $chefs,
            'etablissementSections' => $etablissementSections,
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
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'nullable',
            'telephone' => 'nullable',
            'etablissement_section_id' => 'required',
        ]);

        ChefEtablissement::create($validated);

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Chef d\'établissement créé avec succès !'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChefEtablissement $chefEtablissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChefEtablissement $chefEtablissement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $chefEtablissement = ChefEtablissement::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'nullable',
            'telephone' => 'nullable',
            'etablissement_section_id' => 'required',
        ]);

        $chefEtablissement->update($validated);

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Chef d\'établissement mis à jour avec succès !'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $chefEtablissement = ChefEtablissement::findOrFail($id);
        $chefEtablissement->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Chef d\'établissement supprimé avec succès !'
        ]);
    }
}
