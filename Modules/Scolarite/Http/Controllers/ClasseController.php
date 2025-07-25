<?php

namespace Modules\Scolarite\Http\Controllers;

use App\Models\Annee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\Niveau;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        return Inertia::render('Classe/Index', [
            'classes' => Classe::where('etablissement_section_id',$table->id)->get(),
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($table){
                $query->where('etablissement_section_id',$table->id);})->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        return Inertia::render('Classe/Create', [
            'section_id' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
            'filieres'=>CycleFiliere::with('filiere')->whereHas('filiere',function ($query) use ($table){
                $query->where('etablissement_section_id',$table->id);})->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $type)
    {
        // dd($request->all(), $type);

        try {
            DB::beginTransaction();
            $annee = Annee::where('actif',1)->first();
            $alphabet = range('A', 'Z');
            $ets_id = Auth::user()->etablissement_id;
            $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
            $etablisement_seion = getSectionEtablissement(Auth::user()->etablissement_id, $type)->first();
            foreach($request->donnees as $donnee){
                if($type<=2){
                    if($donnee['option']=='Alphabet'){
                        $niveau=Niveau::find($donnee['niveau_id']);
                        // dd($niveau);
                            for ($i = 1; $i <= $donnee['nombre']; $i++) {
                                $classe=Classe::where('niveau_id',$niveau->id)->where('etablissement_section_id',$etablisement_seion)->get();

                                if($classe->count()!=0){
                                    $indice=$classe->count();
                                }else{
                                    $indice=0;
                                }

                                $class=Classe::updateOrInsert([
                                    'code' => $niveau->code.' '.$alphabet[$indice],
                                    'libelle' => $niveau->libelle.' '.$alphabet[$indice],
                                ],
                                [
                                'niveau_id' => $donnee['niveau_id'],
                                'etablissement_section_id' => $table->id
                                ]
                                )->first();
                                ClasseAnnee::updateOrInsert([
                                    'annee_id' => $annee->id,
                                    'classe_id' => $class->id
                                ],
                                [

                                ]
                                );
                            }
                }elseif($donnee['option']== 'Numérique'){


                    $niveau=Niveau::find($donnee['niveau_id']);
                    for ($i = 1; $i <= $donnee['nombre']; $i++) {
                        $classe=Classe::where('niveau_id',$donnee['niveau_id'])->where('etablissement_section_id',$etablisement_seion)->get();
                        // dd($classe->count());
                        if($classe->count()!=0){
                            $indice=$classe->count()+1;
                        }else{
                            $indice=1;
                        }

                        $class=Classe::updateOrInsert([
                            'code' => $niveau->code.' '.$indice,
                            'libelle' => $niveau->libelle.' '.$indice,
                        ],
                        [
                        'niveau_id' => $donnee['niveau_id'],
                        'etablissement_section_id' => $table->id
                        ]
                        )->first();

                        ClasseAnnee::updateOrInsert([
                            'annee_id' => $annee->id,
                            'classe_id' => $class->id
                            ],
                            [

                            ]
                            );
                    }

                }
            }else{

                $filiere=CycleFiliere::find($donnee['filiere']);
                foreach ($donnee['niveaux'] as  $niveau_id) {
                    $niveau=Niveau::find($niveau_id);
                    $class=Classe::updateOrInsert([
                        'code' => $filiere->code.'/ '.$niveau->code,
                        'libelle' => $filiere->code.'/ '.$niveau->libelle,
                        'niveau_id' =>$niveau->id,
                        'cycle_filiere_id'=>$filiere->id,
                        'etablissement_section_id' => $table->id
                    ],
                    [

                    ]
                    )->first();

                    ClasseAnnee::updateOrInsert([
                        'annee_id' => $annee->id,
                        'classe_id' => $class->id
                        ],
                        [

                        ]
                        );
                    // dump($niveaux[$i]);
                }


            }

            }
        }catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
        DB::commit();
        return redirect()->route('classes.index', $type)->with('message', [
            'type' => 'success',
            'text' => "Les classes ont été créées avec succès !",
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return Inertia::render('Classe/Edit', [
            'classe' => Classe::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $classe = Classe::find($id);
        $classe->update($request->all());
        $table = DB::table('etablissement_section')->where('id',$classe->etablissement_section_id)->first();
        return redirect()->route('classes.index', $table->section_id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try{
            $classe = Classe::find($id);
            $table = DB::table('etablissement_section')->where('id',$classe->etablissement_section_id)->first();
            $classe->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('classes.index',$table->section_id)->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette classe!",
                ]);

            }
        }
        return redirect()->route('classes.index',$table->section_id)->with('message', [
            'type' => 'success',
            'text' => "La classe a été supprimée avec succès !",
        ]);
    }
}
