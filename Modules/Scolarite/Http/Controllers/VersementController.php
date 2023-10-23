<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


use Modules\Scolarite\Entities\Inscription;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\TypeFrais;

class VersementController extends Controller
{

    // FUNCTION AJAX
    public function ajaxGetInscriptionForVersement(Request $request)
    {
        // dd($request->all());
        $code = $request->code;
        $section = $request->section;
        
        $item = $code ? Inscription::where('code',$code)->whereHas('niveau', function($query) use ($section){
            $query->where('section_id',(int)$section);
        })->with('apprenant','cycleFiliere','annee','niveau','versements.frais.type_frais')->get() : [];
        // dd($item);
        return $item;
    }


    // FIN FUNCTION AJAX


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $frais = TypeFrais::where('etablissement_id',Auth::user()->etablissement_id)->get();
        return Inertia::render('versement/index',[
            'section' => $request->section_id,
            'frais' => $frais
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

        return Inertia::render('versement/create');
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
        return view('scolarite::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scolarite::edit');
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
