<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


use Modules\Scolarite\Entities\Inscription;
use Modules\Scolarite\Entities\Versement;
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

    public function calculFrais(Request $request)
    {
        // dd($request->all());
        $inscription = Inscription::find($request->inscription);
        $type_frais = TypeFrais::find($request->type_frais);
        $frais = Frais::where('type_frais_id',$type_frais->id)->where('annee_id',$inscription->annee_id)->where('niveau_id',$inscription->niveau_id)->first();
        $somme_versee = Versement::where('inscription_id',$inscription->id)->where('frais_id',$frais->id)->sum('montant');
        // dd($inscription,$type_frais,$frais,$somme_versee);
        $result = [
            'somme_versee' => $somme_versee,
            'total' => $frais->montant
        ];
        // dd($result);
        return $result ?? [];
    }

    public function saveVersement(Request $request)
    {
        // dd($request->all());
        if($request->inscription && $request->type_frais && $request->montant){
            $inscription = Inscription::find($request->inscription);
            $type_frais = TypeFrais::find($request->type_frais);
            $frais = Frais::where('type_frais_id',$type_frais->id)->where('annee_id',$inscription->annee_id)->where('niveau_id',$inscription->niveau_id)->first();
            // dd($inscription);
            $versement = Versement::create([
                'inscription_id' => $inscription->id,
                'frais_id' => $frais->id,
                'montant' => (float)$request->montant,
                'date_versement' => date('Y-m-d'),
            ]);
            $list = Inscription::where('code',$inscription->code)->whereHas('niveau', function($query) use ($request){
                $query->where('section_id',(int)$request->section);
            })->with('apprenant','cycleFiliere','annee','niveau','versements.frais.type_frais')->get();
            
            return ['code'=> 1 ,'list' => $list ?? []];
        }else{
            return 'ERREUR';
        }
    }

    public function supVersement(Request $request)
    {
        // dd($request->all());
        if($request->id){
           
            $versement = Versement::find($request->id);
            $versement->delete();

            $list = Inscription::where('code',$versement->inscription->code)->whereHas('niveau', function($query) use ($request){
                $query->where('section_id',(int)$request->section);
            })->with('apprenant','cycleFiliere','annee','niveau','versements.frais.type_frais')->get();
            
            return ['code'=> 1 ,'list' => $list ?? []];
        }else{
            return 'ERREUR';
        }
    }


    // FIN FUNCTION AJAX


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // dd($request->all());
       
        $type_frais = TypeFrais::where('etablissement_id',Auth::user()->etablissement_id)->get();
        // dd($result);
        return Inertia::render('versement/index',[
            'section' => $request->section_id,
            'type_frais' => $type_frais,
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
