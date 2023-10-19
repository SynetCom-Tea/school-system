<?php

namespace Modules\Enseignement\Http\Controllers;

use Inertia\Inertia;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Enseignement\Entities\Filiere;

class FilliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        // dd(Filiere::where('etablissement_id',Auth::user()->etablissement_id)->with('cycle_filieres.cycle')->get());
        return Inertia::render('Filliere/Index', [
            'filieres' => Filiere::where('etablissement_id',Auth::user()->etablissement_id)->with('cycle_filieres.cycle')->get(),
            'cycles'=>Cycle::all(),
            'section_id' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        //
        return Inertia::render('Filliere/Create', [
            'filieres' => Filiere::where('etablissement_id',Auth::user()->etablissement_id)->with('cycle_filieres.cycle')->get(),
            'cycles'=>Cycle::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'cycle_id' => 'required',
        ]);
        Filiere::create($data);
        return redirect()->route('fillieres.index')->with('message', [
            'type' => 'success',
            'text' => 'Filière créé avec succès!',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $filiere = Filiere::find($id);
        $filiere->update($request->all());
         return redirect()->route('fillieres.index')->with('message', [
            'type' => 'success',
            'text' => 'Filière modifiée  avec succès!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
