<?php

namespace Modules\Scolarite\Http\Controllers;

use Inertia\Inertia;
use App\Models\Annee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\EtablissementSection;
use Illuminate\Support\Facades\Redirect;

class AnneeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Annee/Index', [
            'annees' => Annee::all()
        ]);
    }


    public function store(Request $request)
    {
        // Validation uniquement de libelle
        $validated = $request->validate([
            'libelle' => 'required|string|unique:annees,libelle',
        ]);

        // 1️⃣ Récupération automatique de etablissement_section_id

        $etablissementSection = EtablissementSection::where('etablissement_id', auth()->user()->etablissement_id)->firstOrFail();
        // dd($etablissementSection->id);
        // dd($anneeEncours);

        $anneeEnAttente = Annee::where('actif', 0)->first();
        if ($anneeEnAttente ) {
            return Redirect::back()->with('message', [
                'type' => 'error',
                'text' => "une année est déjà en attente d'activation.",
            ]);
        }

        Annee::create([
            'libelle' => $validated['libelle'],
            'actif'   => 0,
            'etablissement_section_id' => $etablissementSection->id,
        ]);

        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "L'année a été créée avec succès !",
        ]);
    }


    // Activer une année
    public function activeYear($id)
    {
        $annee = Annee::findOrFail($id);

        // Activer l'année sélectionnée
        $annee->actif = 1;
        $annee->save();
        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "Le statut de l'année a été mis à jour avec succès !",
        ]);
    }

    // Clôturer une année
    public function closeYear($id)
    {
        $annee = Annee::findOrFail($id);
        $anneeActive = Annee::where('actif', 1)->first();
        // dd($anneeActive);

        // Désactiver l'année sélectionnée
        $annee->actif = 2;
        $annee->save();
        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "Le statut de l'année a été mis à jour avec succès !",
        ]);
    }

    // Archiver une année
    public function archiveYear($id)
    {
        $annee = Annee::findOrFail($id);
        $anneeActive = Annee::where('actif', 1)->first();
        // dd($anneeActive);

        // Désactiver l'année sélectionnée
        $annee->actif = 3;
        $annee->save();
        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "Le statut de l'année a été mis à jour avec succès !",
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return Inertia::render('Annee/Edit', [
            'annee' => Annee::find($id)
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
        $annee = Annee::findOrFail($id);
        // dd($annee);
        // Ici on autorise la mise à jour de actif
        $validated = $request->validate([
            'libelle' => 'required|string|unique:annees,libelle,' . $annee->id,
            'actif'   => 'boolean',
        ]);

        $annee->update($validated);

        return redirect()->route('annees.index')->with('message', [
            'type' => 'success',
            'text' => "L'année a été modifiée avec succès !",
        ]);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $annee = Annee::find($id);
            $annee->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
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
