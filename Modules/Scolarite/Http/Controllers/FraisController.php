<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\TypeFrais;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\Niveau;
use App\Models\Annee;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Scolarite\Entities\EtablissementTypeFrais;

class FraisController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request,$type)
    {

        $ets_id = getSectionEtablissement(Auth::user()->etablissement_id, $type)->first();
        // dd($ets_id);
        // $frais=Frais::with('annee','niveau','etablissement_type_frais.type_frais')->whereHas('etablissement_type_frais',function ($query) use ($ets_id){
        //     $query->where('etablissement_section_id',$ets_id);
        // })->whereHas('niveau',function ($query) use ($type){

        //     $query->where('section_id',$type);})->get();

        // $ets_id = Auth::user()->etablissement_id;
        // $frais=Frais::with('annee','niveau','type_frais')->where('etablissement_id',$ets_id)->whereHas('niveau',function ($query) use ($type){

        //     $query->where('section_id',$type);})->get();
        $frais=[];
        $filiere = null;
        $annee_cour=Annee::where('actif',1)->first();
        if ($type>=3 ) {
            $frai_cyclefiliere=Frais::with('niveau')->where('etablissement_id',Auth::user()->etablissement_id)->whereHas('niveau',function ($query) use ($type){
                $query->where('section_id',$type);})->where('annee_id',$annee_cour->id)->latest()->first();
            //  dd($frai_cyclefiliere);
                if($frai_cyclefiliere != []){
                    $filiere = CycleFiliere::find($frai_cyclefiliere->cycle_filiere_id)->id;
                }
            }
        // dd($annee_cour->id);
        $niveaux=Niveau::where('section_id',$type)->get();
        // dd($request->annee);
            $filieres_annee=[];
            foreach($niveaux as $niveau){
             if($type<=2){
                $frai=Frais::with('annee','niveau','etablissement_type_frais.type_frais')->where('etablissement_id',Auth::user()->etablissement_id)->where('niveau_id',$niveau->id)->where(function ($query) use ($request,$annee_cour){
                    if($request->annee!=null){
                        return $query->where('annee_id',$request->annee);
                    }else{
                        return $query->where('annee_id',$annee_cour->id);
                    }
                })->get();


                // $frai=Frais::with('annee','niveau','etablissement_type_frais.type_frais')->where('etablissement_id',$ets_id)->where('niveau_id',$niveau->id)->where('annee_id',$request->annee)->get();
                if ($frai->count() != 0)
                {
                    // $key = $key - 1;
                    $tabs= [
                        'annee'=>$request->annee ? Annee::find( $request->annee): $annee_cour,
                        'niveau' =>$niveau,
                        'frais' => $frai
                    ];
                    $frais[] = $tabs;

                }
            }else{

                    $frai= Frais::with('annee','niveau','etablissement_type_frais.type_frais')->where('etablissement_id',Auth::user()->etablissement_id)->where('niveau_id',$niveau->id)->where(function ($query) use ($request,$annee_cour){
                        if($request->annee!=null){
                            return $query->where('annee_id',$request->annee);
                        }else{
                            return $query->where('annee_id',$annee_cour->id);
                        }
                    })->where(function ($query) use ($request,$filiere){
                        if($request->filiere != null){
                            return  $query->where('cycle_filiere_id',$request->filiere);
                        }else{
                            return  $query->where('cycle_filiere_id',$filiere);
                        }
                        })->get();

                        // dump($frai);
                    // $frai=Frais::with('annee','niveau','etablissement_type_frais.type_frais')->where('etablissement_id',$ets_id)->where('niveau_id',$niveau->id)->where('annee_id',$request->annee)->get();
                    if ($frai->count() != 0)
                    {
                        // $key = $key - 1;
                        $tabs= [
                            'annee'=>$request->annee ? Annee::find( $request->annee): $annee_cour,
                            'niveau' =>$niveau,
                            'frais' => $frai
                        ];
                        $frais[] = $tabs;

                    }


            }

            }
            // dd($frais);

         if($type>=3){
                $filieres_annee=[
                    'annee'=>$request->annee ? Annee::find( $request->annee) : $annee_cour,
                    'filiere'=>$request->filiere?CycleFiliere::find($request->filiere):CycleFiliere::find($filiere)   ,
                ];
        }else{
            $filieres_annee=[
                'annee'=>$request->annee ? Annee::find( $request->annee) : $annee_cour,
                'filiere'=>'',
            ];
        }

        // dd($filieres_annee);
        return Inertia::render('Frais/Index', [
            'frais' => $frais,
            'filieres_annee'=>$filieres_annee,
            'typefrais' => EtablissementTypeFrais::where('etablissement_section_id',$ets_id)->where('statut',1)->with('type_frais')->get(),
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($ets_id){
                $query->where('etablissement_section_id',$ets_id);})->get(),
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
            'filieres' => CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($ets_id){
                $query->where('etablissement_section_id',$ets_id);})->get(),
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
            if($type ==3 || $type== 4)
               { Frais::updateOrInsert([
                    'niveau_id' => $niv,
                    'annee_id' => $request->annee_id,
                    'etablissement_type_frais_id' => $donnee['type_frais_id'],
                    'montant' => $donnee['montant'],
                    'cycle_filiere_id' => $donnee['filiere'],
                    'etablissement_id' => $ets_id,
                ],
                [
                'deleted_at'=>null,
                'created_at' => now(), // Remplissez le champ created_at
                'updated_at' => now() // Remplissez le champ updated_at
                ]
                );}else{

                    Frais::updateOrInsert([
                        'niveau_id' => $niv,
                        'annee_id' => $request->annee_id,
                        'etablissement_type_frais_id' => $donnee['type_frais_id'],
                        'montant' => $donnee['montant'],
                        'etablissement_id' => $ets_id,
                    ],
                    [
                    'deleted_at'=>null,
                    'created_at' => now(), // Remplissez le champ created_at
                    'updated_at' => now() // Remplissez le champ updated_at
                    ]
                    );

                }
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
    public function supprimer($id)
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

