<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Annee;
use App\Models\ClasseAnnee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\EnseignantMatiere;
use Modules\Enseignement\Entities\EnseignementAnnee;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\NiveauMatiere;

use function PHPSTORM_META\map;

class AffectationEnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index( Request $request,$type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $annee = Annee::where('actif',1)->first();


        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();

        $allmatiere=Matiere::where('etablissement_section_id',$table->id)->get();
        // $classes = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table){
        //     $classe->where('etablissement_section_id',$table->id);
        // })->whereHas('annee',function($anne) use ($annee){
        //     $anne->where('annee_id',$annee->id);
        // })->get();

        // dd($classes);
        $enseignement_annees=EnseignementAnnee::whereHas('classe_annee.classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->with('niveau_matiere.matiere','classe_annee.classe','classe_annee.annee','enseignant')->get();

        $niveauMat = NiveauMatiere::with('matiere','niveau')->whereHas('matiere',function ($query) use ($table){

            $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){

            $query->where('section_id',$type);})->get();
        $list = [];
        $list1 = [];
        $tabs=collect();
        // dd($list_classes);
        foreach($enseignants as $enseignant){
            foreach($enseignement_annees as $enseignement_annee){
                // $i = 0;
                if($enseignant->id == $enseignement_annee->enseignant_id){

                    $list[] = [
                        'id' => $enseignement_annee,
                        'matiere' => $enseignement_annee->niveau_matiere->matiere,
                        'classe' => $enseignement_annee->classe_annee->classe,
                    ];
                }
            }
            $list1[$enseignant->id] = $list;
            $list = [];
        }


        foreach($enseignants as $key=> $enseignant){

            foreach($enseignement_annees as $enseignement_annee){

                if($enseignant->id == $enseignement_annee->enseignant->id){
                    $tabs[$key] = [
                        'enseignant'=>$enseignement_annee->enseignant,
                        'list' => $list1[$enseignant->id],
                        'annee'=>$enseignement_annee->classe_annee->annee->libelle,
                    ];

                }

            }

        }
        $tableau=collect();
        $tabs->map(function($element) use ($tableau){
            return $tableau->push($element);
        });

        $classesA=[];
        $classe_annees=[];
        $mat = $request->matiere ? Matiere::where('id',$request->matiere)->first():null;

        if($mat!=null){

                    $classesA = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($mat){
                        $classe->where('etablissement_section_id',$mat->etablissement_section_id);
                    })->whereHas('annee',function($anne) use ($annee){
                        $anne->where('annee_id',$annee->id);
                    })->get();



        }
        $enseignement_annee=EnseignementAnnee::all();
        foreach($classesA as $classe){
            $trouver=false;
            $Niveau_matieres=NiveauMatiere::where('matiere_id',$mat->id)->get();
            foreach($Niveau_matieres as $Niveau_matiere){

                if( $classe->classe->niveau_id== $Niveau_matiere->niveau_id){
                    // dump($classe->classe->niveau_id);
                    foreach($enseignement_annee as $enseignement_anne){
                        if($enseignement_anne->classe_annee_id==$classe->id &&  $enseignement_anne->niveau_matiere_id== $Niveau_matiere->id ){
                                $trouver=true;

                        }
                    }
                    if($trouver==false){
                        $classe_annees[]=$classe;
                    }
                }


            }


        }
        // $tableau=$tabs;
        // dd($tableau);

        //    dump($enseignement_annee);

        // dd($all);
        // die();
        // dd( $enseignement_annee);

        return Inertia::render('AffectationEnseignants/Index', [
            'niveauMatieres' => $allmatiere,
            'enseignants' => $enseignants,
            'classes'=>$classe_annees,
            'enseignements'=>$tableau,
            'section_id' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($type,Request $request)
    {
        // dd($request->matiere ?? 3);
        // $dernierId=Annee::max('id');
        // $annee = Annee::where('id', $dernierId)->first();
        // $ets_id = Auth::user()->etablissement_id;
        // $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        // $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        // $classes = collect();

        // $niveauMat = NiveauMatiere::with('matiere','niveau')->whereHas('matiere',function ($query) use ($table){

        //     $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){

        //     $query->where('section_id',$type);})->get();
        // $niveaux = $request->matiere ? NiveauMatiere::where('matiere_id',$request->matiere)->get() : [];
        // foreach($niveaux as $element){
        //     $tabs = $request->matiere? ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table,$element){
        //         $classe->where('etablissement_section_id',$table->id)->where('niveau_id',$element->niveau_id);
        //     })->whereHas('annee',function($anne) use ($annee){
        //         $anne->where('annee_id',$annee->id);
        //     })->get() : [];
        //     $classes[]=$tabs;
        // }
        // dd($classes);


        $ets_id = Auth::user()->etablissement_id;
        $annee = Annee::where('actif',1)->first();
        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $matiere=[];
        $classes=[];
        $classe_annees=[];
        $etablissement_section_id= DB::table('etablissement_section')->where('etablissement_id', $ets_id)->get();

        $mat = $request->matiere ? Matiere::where('id',$request->matiere)->first():null;

        if($mat!=null){

                    $classes = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($mat){
                        $classe->where('etablissement_section_id',$mat->etablissement_section_id);
                    })->whereHas('annee',function($anne) use ($annee){
                        $anne->where('annee_id',$annee->id);
                    })->get();



        }
        $enseignement_annee=EnseignementAnnee::all();
        foreach($classes as $classe){
            $trouver=false;
            $Niveau_matieres=NiveauMatiere::where('matiere_id',$mat->id)->get();
            foreach($Niveau_matieres as $Niveau_matiere){

                if( $classe->classe->niveau_id== $Niveau_matiere->niveau_id){
                    // dump($classe->classe->niveau_id);
                    foreach($enseignement_annee as $enseignement_anne){
                        if($enseignement_anne->classe_annee_id==$classe->id &&  $enseignement_anne->niveau_matiere_id== $Niveau_matiere->id ){
                                $trouver=true;

                        }
                    }
                    if($trouver==false){
                        $classe_annees[]=$classe;
                    }
                }


            }


        }
        $allmatiere=Matiere::where('etablissement_section_id',$table->id)->get();
        return Inertia::render('AffectationEnseignants/Create', [
            'section_id' => $type,
            'classes'=>$classe_annees,
            'enseignants' => $enseignants,
            'matieres' => $allmatiere,
        ]);
        // return view('enseignement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$type)
    {

        // dd($request->matieres);
        $ets_id = Auth::user()->etablissement_id;

        foreach($request->matieres as $matiere){


            //  dd($Niveau_matieres);

                foreach($matiere['classes'] as $classe){

                $classe_annee=ClasseAnnee::with('classe')->where('id',$classe)->first();
                $Niveau_matiere=NiveauMatiere::where('matiere_id',$matiere['matiere'])->where('niveau_id',$classe_annee->classe->niveau_id)->first();
                // dd($Niveau_matiere);

                        EnseignementAnnee::updateOrInsert([
                            'niveau_matiere_id' => $Niveau_matiere->id,
                            'classe_annee_id' => $classe_annee->id,
                            'enseignant_id' => $request->enseignant,

                        ],
                        [
                            'created_at' => now(), // Remplissez le champ created_at
                            'updated_at' => now() // Remplissez le champ updated_at
                        ]
                        );
                    }

                    // dd($classe);

                // dd($classe);

        }
        return redirect()->route('AffectationEnseignants.index', $type)->with('message', [
            'type' => 'success',
            'text' => "Affectation a été affectée  avec succès !",
        ]);
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
        dd($id);
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



        $classe_annee=ClasseAnnee::with('classe')->where('id',$request->classe)->first();
        $Niveau_matiere=NiveauMatiere::where('matiere_id',$request->matiere)->where('niveau_id',$classe_annee->classe->niveau_id)->first();
        // dd($classe_annee->classe->niveau_id);
                EnseignementAnnee::updateOrInsert([
                    'niveau_matiere_id' => $Niveau_matiere->id,
                    'classe_annee_id' => $classe_annee->id,
                    'enseignant_id' => $request->enseignant,

                ],
                [
                    'created_at' => now(), // Remplissez le champ created_at
                    'updated_at' => now() // Remplissez le champ updated_at
                ]
                );





    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        // dd($id);
        try{
            $enseignement_annee = EnseignementAnnee::find($id);
            $enseignement_annee->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette affectation!",
                ]);

            }
        }
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => "L'affectation a été supprimé avec succès !",
        ]);
        //

    }
}
