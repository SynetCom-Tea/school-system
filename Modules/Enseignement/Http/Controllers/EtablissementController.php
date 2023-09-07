<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Etablissement;
use Modules\Enseignement\Entities\Filliere;
use App\Models\TypeEtablissement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Inertia\Inertia;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Enseignement/Etablissement/Index', [
            'type_etablissements' => TypeEtablissement::all(),
            'etablissements' => Etablissement::with('type_etablissement')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Enseignement/Etablissement/Create', [
            'types' => TypeEtablissement::all(),
            'fillieres' => Filliere::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // $this->validate($request, [
        //     'name' => 'required|string|max:255',
        //     'type_etablissement_id' => 'required',
        // ]);
        $etablissement = Etablissement::create($request->all());
        return redirect()->route('etablissements.index')->with('message', [
            'type' => 'success',
            'text' => "L'etablissement a été crée avec succès !",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Etablissement $etablissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etablissement $etablissement)
    {
        // dd($etablissement->load('type_etablissement', 'facultes.fillieres', 'fillieres'));
        return Inertia::render('Enseignement/Etablissement/Edit', [
            'types' => TypeEtablissement::all(),
            'fillieres' => Filliere::all(),
            'etablissement' => $etablissement->load('type_etablissement', 'facultes.fillieres', 'fillieres')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etablissement $etablissement)
    {
        // dd($etablissement, $request->all());
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|array',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'type_etablissement_id' => 'required',
        ]);
        $etablissement->update($request->all());
        if($request->type_etablissement_id == 1){
            foreach($request->facultes as $faculte){
                Faculte::updateOrCreate([
                    'code' => $faculte['code'],
                    'name'=>$faculte['name'],
                    'etablissement_id' => $etablissement->id
                ])->fillieres()->sync($faculte['filliere']);
            }
        }else{
            $etablissement->fillieres()->sync($request->filliere);
        }
        return redirect()->route('etablissements.index')->with('message', [
            'type' => 'success',
            'text' => "L'etablissement a été modifier avec succès !",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etablissement $etablissement)
    {
        dd($etablissement);
    }
}
