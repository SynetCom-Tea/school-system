<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\ApprenantClasseAnnee;
use App\Models\Conduite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Modules\GestionNote\Entities\Periode;

class ConduiteController extends Controller
{
    public function index(Request $request)
    {
        $sectionId = (int) $request->input('section_id', 2);
        $annee = Annee::where('actif', 1)->first();
        $classes = collect();
        $eleves = collect();

        if ($annee && Auth::user()?->etablissement_id) {
            $etablissementSection = getSectionEtablissement(Auth::user()->etablissement_id, $sectionId);
            $classes = getClasses($annee->id, $etablissementSection);
        }

        $periodes = $sectionId === 1
            ? Periode::where('type', 'Trimestre')->get()
            : Periode::where('type', 'Semestre')->get();

        if ($request->filled('classe') && $request->filled('periode')) {
            $conduites = Conduite::where('classe_annee_id', $request->classe)
                ->where('periode_id', $request->periode)
                ->get()
                ->keyBy('apprenant_id');

            $eleves = ApprenantClasseAnnee::where('classe_annee_id', $request->classe)
                ->join('apprenants', 'apprenant_classe_annees.apprenant_id', '=', 'apprenants.id')
                ->orderBy('apprenants.nom')
                ->orderBy('apprenants.prenom')
                ->select('apprenant_classe_annees.*')
                ->with('apprenant')
                ->get()
                ->map(function ($item) use ($conduites) {
                    $conduite = $conduites->get($item->apprenant_id);

                    return [
                        'apprenant_id' => $item->apprenant_id,
                        'matricule' => $item->apprenant->matricule,
                        'nom_complet' => trim($item->apprenant->nom . ' ' . $item->apprenant->prenom),
                        'note' => $conduite ? (float) $conduite->note : 18,
                    ];
                });
        }

        return Inertia::render('Conduite/Index', [
            'sectionID' => $sectionId,
            'classes' => $classes,
            'periodes' => $periodes,
            'eleves' => $eleves,
            'filters' => [
                'classe' => $request->classe,
                'periode' => $request->periode,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'classe' => ['required', 'integer', 'exists:classe_annees,id'],
            'periode' => ['required', 'integer', 'exists:periodes,id'],
            'notes' => ['required', 'array'],
            'notes.*.apprenant_id' => ['required', 'integer', 'exists:apprenants,id'],
            'notes.*.note' => ['required', 'numeric', 'min:0', 'max:20'],
        ]);

        foreach ($data['notes'] as $note) {
            Conduite::updateOrCreate(
                [
                    'apprenant_id' => $note['apprenant_id'],
                    'classe_annee_id' => $data['classe'],
                    'periode_id' => $data['periode'],
                ],
                [
                    'note' => $note['note'],
                    'user_id' => Auth::id(),
                ]
            );
        }

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Notes de conduite enregistrées avec succès!',
        ]);
    }
}
