<?php

namespace Modules\Enseignement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Matiere;
use App\Models\EtablissementSection;


use Inertia\Inertia;


class EnseignementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // dd(Auth::user());
        return Inertia::render('Admin/accueil');
    }

    public function config($type)
    {
        // dd(Auth::user());
        $eta_section_id = EtablissementSection::where('etablissement_id',Auth::user()->etablissement_id)->where('section_id',$type)->first();
        // dd($eta_section_id);
        return Inertia::render('Admin/config',[
            'type' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'matieres' => Matiere::where('etablissement_section_id',$eta_section_id->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('enseignement::create');
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
        return view('enseignement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('enseignement::edit');
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
