<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\Filiere;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;
use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\NiveauMatiere;
use Modules\Enseignement\Entities\Ue;

class AffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $niveauMat=collect();
        $niveaux= Niveau::where('section_id',$type)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $cycle_filieres= CycleFiliere::with('cycle','filiere')->whereHas('filiere',function ($query) use ($table){
            $query->where('etablissement_section_id',$table->id);})->get();
        if($type >=3 && $table->systeme_lmd_id!=null ){
            $ues=Ue::where('etablissement_section_id',$table->id)->get();
            foreach($cycle_filieres as $cycle_filiere){
                foreach($niveaux as $niveau){
                    $niveauMt=[];
                    foreach($ues as $ue){
                    $niveauM= FiliereNiveauMatiereUe::with('matiere','niveau','ue','cycle_filiere')->whereHas('matiere',function ($query) use ($table){
                        $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){
                        $query->where('section_id',$type);})->where('cycle_filiere_id', $cycle_filiere->id)->where('niveau_id', $niveau->id)->where('ue_id', $ue->id)->get();
                        if ($niveauM->count() != 0) {
                            $credit=0;
                            foreach( $niveauM as  $niveaumat){
                                $credit=$credit+$niveaumat->coefficient;
                            }
                            $niveauMt[]=[
                                'matieres'=>$niveauM,
                                'ue' => $ue,
                                'credit'=>$credit
                            ];
                        }
                    }
                    if (count($niveauMt) != 0) {
                        // $key = $key - 1;
                        $tabs= [
                            'ues'=>$niveauMt,
                            'cycle_filiere' =>$cycle_filiere,
                            'niveau' => $niveau,

                        ];
                        $niveauMat[] = $tabs;
                    }
                }

            }

    // dd($niveauMat);
            return Inertia::render('AffectationNiveauMatiere/Index', [
                'niveauMatieres' => $niveauMat,
                'section_id' => $type,
                'niveaux' => Niveau::where('section_id',$type)->get(),
                'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
                'systemeLMD'=>$table->systeme_lmd_id,
                'ues'=>Ue::where('etablissement_section_id',$table->id)->get(),
                'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($table){
                    $query->where('etablissement_section_id',$table->id);})->get(),
            ]);     // dd($niveauMat);
    }else {
        if($type <= 2){
            foreach($niveaux as $niveau){

                $niveauMt= NiveauMatiere::with('matiere','niveau')->whereHas('matiere',function ($query) use ($table){

                $query->where('etablissement_section_id',$table->id);})->where('niveau_id',$niveau->id)->get();

                if ($niveauMt->count() != 0) {

                    $niveauMat[]=[
                        'matiere'=>$niveauMt,
                        'niveau' => $niveau,
                    ];
                }
            }
        }else{
            foreach($cycle_filieres as $cycle_filiere){
                foreach($niveaux as $niveau){

                    $niveauMt= FiliereNiveauMatiereUe::with('matiere','niveau','cycle_filiere')->whereHas('matiere',function ($query) use ($table){
                        $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){
                        $query->where('section_id',$type);})->where('cycle_filiere_id', $cycle_filiere->id)->where('niveau_id', $niveau->id)->get();

                    if ($niveauMt->count() != 0) {

                        $niveauMat[]=[
                            'matiere'=>$niveauMt,
                            'niveau' => $niveau,
                            'cycle_filiere' => $cycle_filiere,
                        ];
                    }
                }
            }
        }
        // dd($niveauMat);
        return Inertia::render('AffectationNiveauMatiere/Index', [
            'niveauMatieres' => $niveauMat,
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
            'systemeLMD'=>$table->systeme_lmd_id,
            'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($table){
                $query->where('etablissement_section_id',$table->id);})->get(),
        ]);
    }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
       if($type==3 && $table->systeme_lmd_id!=null){
            return Inertia::render('AffectationNiveauMatiere/CreateSup', [
                'type' => $type,
                'niveaux' => Niveau::where('section_id',$type)->get(),
                'ues' => Ue::where('etablissement_section_id',$table->id)->get(),
                'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($table){
                    $query->where('etablissement_section_id',$table->id);})->get(),
                'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
            ]);
        }else{
            return Inertia::render('AffectationNiveauMatiere/Create', [
                'section_id' => $type,
                'niveaux' => Niveau::where('section_id',$type)->get(),
                'matieres' => Matiere::where('etablissement_section_id',$table->id)->get(),
                'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($table){
                    $query->where('etablissement_section_id',$table->id);})->get(),
                'systemeLMD'=>$table->systeme_lmd_id,
            ]);


        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();

        if($type>=3 && $table->systeme_lmd_id !=null){
            if($request->ues){
                // dd($request->ues);
                foreach($request->ues as $ues){
                    // dd($classe);
                    $ue=Ue::create(['code' => $ues['code_ue'], 'libelle' => $ues['nom_ue'], 'etablissement_section_id' =>  $table->id,]);
                    foreach($ues['matieres'] as $matiere){
                        // dd($matiere);
                        FiliereNiveauMatiereUe::updateOrInsert([
                            'matiere_id' => $matiere['matiere'],
                            'niveau_id' => $request->niveau,
                            'ue_id' => $ue->id,
                            'cycle_filiere_id' => $request->filiere,

                        ],
                        [
                            'volume_horaire' => $matiere['volume_horaire'],
                            'coefficient' => $matiere['coefficient']
                        ]
                        );
                    }
                }
            }else{
                // dd($request);
                FiliereNiveauMatiereUe::updateOrInsert([
                    'matiere_id' => $request->matiere_id,
                    'niveau_id' => $request->niveau_id,
                    'ue_id' => $request->ue_id,
                    'cycle_filiere_id' => $request->cycle_filiere_id,

                ],
                [
                    'volume_horaire' => $request->volume_horaire,
                    'coefficient' => $request->coefficient
                ]
                );
            }

        }else if($type>=3 && $table->systeme_lmd_id ==null){
                // dd($type);
                foreach($request->Affectations as $Affectation){
                    foreach($Affectation['niveau_id'] as $niv){

                        FiliereNiveauMatiereUe::updateOrInsert([
                                'matiere_id' => $Affectation['matiere_id'],
                                'niveau_id' => $niv,
                                'volume_horaire' => $Affectation['volume_horaire'],
                                'coefficient' => $Affectation['coefficient'],
                                'cycle_filiere_id' => $request->filiere,
                                ],
                                []);
                    }
                }


        }else if($type==1){
            foreach($request->Affectations as $Affectation){
            foreach($Affectation['niveau_id'] as $niv){

                    NiveauMatiere::updateOrInsert([
                        'matiere_id' => $Affectation['matiere_id'],
                        'niveau_id' => $niv,
                        'volume_horaire' => $Affectation['volume_horaire'],
                        'notation' => $Affectation['coefficient']
                        ],
                        []
                    );
                }
            }
        }else{
            foreach($request->Affectations as $Affectation){
                foreach($Affectation['niveau_id'] as $niv){
                    NiveauMatiere::updateOrInsert([
                            'matiere_id' => $Affectation['matiere_id'],
                            'niveau_id' => $niv,
                            'volume_horaire' => $Affectation['volume_horaire'],
                            'coefficient' => $Affectation['coefficient'],
                            ],
                            []
                        );
                }

            }
        }
        return redirect()->route('affectations.index', $type)->with('message', [
            'type' => 'success',
            'text' => "La matière a été affectée aux niveaux avec succès !",
        ]);
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
        //  dd($request);
        if($request->type<=2){
            $aff = NiveauMatiere::find($id);
            $aff->update($request->all());
            $table = Niveau::where('id',$aff->niveau_id)->first();
            return redirect()->route('affectations.index', $table->section_id);
        }else{
            $aff = FiliereNiveauMatiereUe::find($id);
            $aff->update($request->all());
            $table = Niveau::where('id',$aff->niveau_id)->first();
            return redirect()->route('affectations.index', $table->section_id);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,Request $niveau)
    {
        // dd($niveau);
        try{
            if($niveau->type==1 || $niveau->type==2  ){
                $aff = NiveauMatiere::find($id);

            }else if($niveau->type==3 || $niveau->type==4){

                $aff = FiliereNiveauMatiereUe::find($id);
            }

            $table = Niveau::where('id',$aff->niveau_id)->first();
            $aff->delete();

        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('affectations.index',$table->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer la matière de ce niveau!",
                ]);

            }
        }
        return redirect()->route('affectations.index',$table->section_id)->with('message', [
            'type' => 'success',
            'text' => "La matière a été supprimée de ce niveau avec succès !",
        ]);
    }


    public function niveausupprime( $id,Request $niveau)
    {
        // dd($id);
        try{

            if($niveau->type==1 || $niveau->type==2  ){
                $affs = NiveauMatiere::where('niveau_id',$id)->get();

            }else if($niveau->type==3 || $niveau->type==4){

                $affs = FiliereNiveauMatiereUe::where('niveau_id',$id)->get();
            }

            $table = Niveau::where('id',$id)->first();

            foreach($affs as $aff){
                $aff->delete();
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('affectations.index',$table->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer la matière de ce niveau!",
                ]);

            }
        }
        return redirect()->route('affectations.index',$table->section_id)->with('message', [
            'type' => 'success',
            'text' => "La matière a été supprimée de ce niveau avec succès !",
        ]);
    }




    public function supprimerUE($id,Request $ue)
    {
        // dd($id);
        try{
                $affs = FiliereNiveauMatiereUe::where('cycle_filiere_id',$ue->cycle_filiere_id)->where('ue_id',$id)->where('niveau_id',$ue->niveau_id)->get();
                $table = Niveau::where('id',$ue->niveau_id)->first();
                foreach($affs as $aff){
                    $aff->delete();
                }

        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('affectations.index',$table->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer la matière de ce niveau!",
                ]);

            }
        }
        return redirect()->route('affectations.index',$table->section_id)->with('message', [
            'type' => 'success',
            'text' => "La matière a été supprimée de ce niveau avec succès !",
        ]);
    }






}



