<?php

namespace Modules\GestionNote\Http\Controllers;

use Modules\GestionNote\Entities\Apprenant;
use Modules\GestionNote\Entities\Classe;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // recuperer l'utilisateur connecté
        //Auth::user()->professeur_id;
        $classes = [
            ['id' => 1, 'libelle' => '6e'],
            ['id' => 2, 'libelle' => '5e'],
            // ... Autres éléments de classe
        ];
        // $classes = collect($classes1);
        // dd($classes,$classes1);
        // $test = Apprenant::all();
        //  dd($classes);
        // Inertia::share('classes', $classes);

        // return Inertia::render('VotreVue');
        return Inertia::render('gestion-note/note/index',[
            'classes' => $classes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('gestionnote::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gestionnote::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('gestionnote::edit');
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
