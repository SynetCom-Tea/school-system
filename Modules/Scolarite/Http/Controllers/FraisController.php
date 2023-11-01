<?php

namespace Modules\Scolarite\Http\Controllers;

use Inertia\Inertia;
use App\Models\Annee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Scolarite\Entities\Frais;
use Illuminate\Support\Facades\Redirect;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\EtablissementTypeFrais;
use Modules\Scolarite\Entities\TypeFrais;

class FraisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($type)
    {
        $ets_id = getSectionEtablissement(Auth::user()->etablissement_id, $type);
        $frais=Frais::with('annee','niveau','etablissement_type_frais.type_frais')->whereHas('etablissement_type_frais',function ($query) use ($ets_id){
            $query->where('etablissement_section_id',$ets_id);
        })->whereHas('niveau',function ($query) use ($type){

            $query->where('section_id',$type);})->get();

        return Inertia::render('Frais/Index', [
            'frais' => $frais,
            'typefrais' => EtablissementTypeFrais::where('etablissement_section_id',$ets_id)->where('statut',1)->with('type_frais')->get(),
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'annees' => Annee::All(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($type)
    {
        $ets_id = getSectionEtablissement(Auth::user()->etablissement_id, $type);

        return Inertia::render('Frais/Create', [
            'typefrais' => EtablissementTypeFrais::where('etablissement_section_id',$ets_id)->where('statut',1)->with('type_frais')->get(),
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'annees' => Annee::All(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$type)
    {
        // dd($request->all());
        $ets_id = Auth::user()->etablissement_id;
        $ets_section_id = getSectionEtablissement(Auth::user()->etablissement_id, $type);

        foreach($request->donnees as $donnee){
            $etab_type_frais = EtablissementTypeFrais::where('etablissement_section_id',$ets_section_id)->where('statut',1)->where('type_frais_id',$donnee['type_frais_id'])->first();
            foreach($donnee['niveau_id'] as $niv){
                Frais::updateOrInsert([
                    'niveau_id' => $niv,
                    'annee_id' => $request->annee_id,
                    'etablissement_type_frais_id' => $etab_type_frais->id
                ],
                [
                'montant' => $donnee['montant'],
                'etablissement_id' => $ets_id
                ]
                );
            }
        }

        return redirect()->route('frais.index', $type)->with('message', [
            'type' => 'success',
            'text' => "Le frais a été créé avec succès !",
        ]);
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
        $frais = Frais::find($id);
        $frais->update($request->all());
        $niveau = Niveau::where('id',$frais->niveau_id)->first();
        return redirect()->route('frais.index', $niveau->section_id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try{
            $frais = Frais::find($id);
            $niveau = Niveau::where('id',$frais->niveau_id)->first();
            $frais->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->route('frais.index',$niveau->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer ce frais!",
                ]);

            }
        }
        return redirect()->route('frais.index',$niveau->section_id)->with('message', [
            'type' => 'success',
            'text' => "Le frais a été supprimé avec succès !",
        ]);
    }

}
