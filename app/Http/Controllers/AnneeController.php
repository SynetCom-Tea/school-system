<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use Illuminate\Http\Request;

class AnneeController extends Controller
{
    /**
     * Afficher la liste des années académiques.
     */
    public function index()
    {
        $annees = Annee::orderBy('libelle', 'desc')->get();
        return response()->json($annees);
    }

    /**
     * Ajouter une nouvelle année académique.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255|unique:annees,libelle',
            'actif'   => 'nullable|in:0,1',
        ]);

        // Si on crée une année active => désactiver les autres
        if ($request->actif == 1) {
            Annee::where('actif', 1)->update(['actif' => 0]);
        }

        $annee = Annee::create([
            'libelle' => $request->libelle,
            'actif'   => $request->actif ?? 0,
        ]);

        return response()->json([
            'message' => 'Année académique créée avec succès',
            'data' => $annee
        ]);
    }

    /**
     * Afficher une année précise.
     */
    public function show($id)
    {
        $annee = Annee::findOrFail($id);
        return response()->json($annee);
    }

    /**
     * Modifier une année académique.
     */
    public function update(Request $request, $id)
    {
        $annee = Annee::findOrFail($id);

        $request->validate([
            'libelle' => 'required|string|max:255|unique:annees,libelle,' . $id,
            'actif'   => 'nullable|in:0,1',
        ]);

        // Gestion de l'année active
        if ($request->actif == 1) {
            Annee::where('actif', 1)->update(['actif' => 0]);
        }

        $annee->update($request->only('libelle', 'actif'));

        return response()->json([
            'message' => 'Année académique mise à jour avec succès',
            'data' => $annee
        ]);
    }

    /**
     * Supprimer une année.
     */
    public function destroy($id)
    {
        $annee = Annee::findOrFail($id);
        $annee->delete();

        return response()->json(['message' => 'Année supprimée avec succès']);
    }

    /**
     * Forcer une année à devenir active.
     */
    public function activer($id)
    {
        // Désactiver toutes les années
        Annee::where('actif', 1)->update(['actif' => 0]);

        // Activer celle-ci
        $annee = Annee::findOrFail($id);
        $annee->update(['actif' => 1]);

        return response()->json([
            'message' => 'Année activée',
            'data' => $annee
        ]);
    }
}
