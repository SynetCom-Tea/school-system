<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Annee;
use App\Models\MenuGestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function indexPrimaire(Request $request, $annee)
    {
        // dd($annee);
        $authUser = Auth::user();
        $t = User::where('users.etablissement_id', $authUser->etablissement_id)
            ->join(
                'etablissement_section',
                'users.etablissement_id',
                '=',
                'etablissement_section.etablissement_id',


            )->where('etablissement_section.section_id', 1)
            ->selectRaw('users.*')
            ->get();
        // dd('$terre:', $t);

        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexPrimaire', ["anneeEncoursId" => $annee]);
    }
    public function indexSecondaire(Request $request, $annee)
    {
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexSecondaire', ["anneeEncoursId" => $annee]);
    }
    public function indexSuperieure(Request $request, $annee)
    {
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexSuperieure', ["anneeEncoursId" => $annee]);
    }
    public function indexUniversitaire(Request $request, $annee)
    {
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexUniversitaire', ["anneeEncoursId" => $annee]);
    }
    public function index()
    {
        //
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
    public function show(MenuGestion $menuGestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuGestion $menuGestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuGestion $menuGestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuGestion $menuGestion)
    {
        //
    }
}
