<?php

namespace App\Http\Controllers;

use App\Models\MenuGestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MenuGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function indexPrimaire(Request $request)
    {
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
        return Inertia::render('Gestion/IndexPrimaire', []);
    }
    public function indexSecondaire(Request $request)
    {
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexSecondaire', []);
    }
    public function indexSuperieure(Request $request)
    {
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexSuperieure', []);
    }
    public function indexUniversitaire(Request $request)
    {
        if (Auth::user() == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('Gestion/IndexUniversitaire', []);
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
