<?php

namespace Modules\Enseignement\Http\Controllers;

use Modules\Enseignement\Entities\Cycle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;


class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('cycle/index', [
            'cycles'=>Cycle::all(),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cycle $cycle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cycle $cycle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cycle = Cycle::find($id);
        $cycle->name = $request->nom;
        $cycle->update();
        return redirect()->route('cycles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cycle = Cycle::find($id);
        $cycle->delete();
        return redirect()->route('cycles.index');
    }
}
