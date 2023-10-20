<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendrierscolaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($parameter)
    {
        return Inertia::render('CalendrierScolaireProgramme/Index', [
            'programmes' => [],
            'section_id' => $parameter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($parameter)
    {
        return Inertia::render('CalendrierScolaireProgramme/Create', [
            'programmes' => [],
            'section_id' => $parameter,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->programmes);
        foreach ($request->programmes as $programme) {
            dd(Carbon::parse($programme['date'], 'UTC'),Carbon::parse($programme['date'])->toDateString(), Carbon::parse($programme['date'])->toTimeString());
            
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
