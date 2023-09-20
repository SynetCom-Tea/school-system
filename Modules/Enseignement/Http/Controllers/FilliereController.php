<?php

namespace Modules\Enseignement\Http\Controllers;

use Modules\Enseignement\Entities\Filliere;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Cycle;
use Illuminate\Routing\Controller;


class FilliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Filliere/Filliere', [
            'fillieres' => Filliere::with('cycle')->get(),
            'cycles'=>Cycle::all()
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
        $data = $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'cycle_id' => 'required',
        ]);
        Filliere::create($data);
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
        $filiere = Filliere::find($id);
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
