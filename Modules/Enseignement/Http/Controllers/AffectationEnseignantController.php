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

class AffectationEnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $dernierId=Annee::max('id');
        $annee = Annee::where('id', $dernierId)->first();


        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();


        $classes = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->whereHas('annee',function($anne) use ($annee){
            $anne->where('annee_id',$annee->id);
        })->get();

        // dd($classes);
        $enseignement_annees=EnseignementAnnee::whereHas('classe_annee.classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->with('niveau_matiere.matiere','classe_annee.classe','classe_annee.annee','enseignant')->get();

        $niveauMat = NiveauMatiere::with('matiere','niveau')->whereHas('matiere',function ($query) use ($table){

            $query->where('etablissement_section_id',$table->id);})->whereHas('niveau',function ($query) use ($type){

            $query->where('section_id',$type);})->get();
        $list = [];
        $list1 = [];
        $tabs=[];
        // dd($list_classes);
        foreach($enseignants as $enseignant){
            foreach($enseignement_annees as $enseignement_annee){
                // $i = 0;
                if($enseignant->id == $enseignement_annee->enseignant->id){

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
        foreach($enseignants as $key => $enseignant){
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
        // dd($tabs);

        //    dump($enseignement_annee);

        // dd($all);
        // die();
        // dd( $enseignement_annee);

        return Inertia::render('AffectationEnseignants/Index', [
            'niveauMatieres' => $niveauMat,
            'enseignants' => $enseignants,
            'classes'=>$classes,
            'enseignements'=>$tabs,
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
        $dernierId=Annee::max('id');
        $annee = Annee::where('id', $dernierId)->first();
        $ets_id = Auth::user()->etablissement_id;
        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $classes = collect();
        $niveaux = $request->matiere ? NiveauMatiere::where('matiere_id',$request->matiere)->get() : [];
        foreach($niveaux as $element){
            $tabs = $request->matiere? ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table,$element){
                $classe->where('etablissement_section_id',$table->id)->where('niveau_id',$element->niveau_id);
            })->whereHas('annee',function($anne) use ($annee){
                $anne->where('annee_id',$annee->id);
            })->get() : [];
            $classes->push($tabs);
        }
        // dd($classes);

        return Inertia::render('AffectationEnseignants/Create', [
            'section_id' => $type,
            'classes'=>$classes,
            'enseignants' => $enseignants,
            'matieres' => $request->enseignant ? EnseignantMatiere::with('matiere')->whereHas('matiere',function($matiere) use ($table){
                $matiere-> where('etablissement_section_id',$table->id);
            })-> where('enseignant_id',$request->enseignant)->get():[],
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

             $Niveau_matieres=NiveauMatiere::where('matiere_id',$matiere['matiere'])->get();
            //  dd($Niveau_matieres);
            foreach($matiere['classes'] as $classe){

                $classe_annee=ClasseAnnee::with('classe')->where('id',$classe)->first();
                // dd($classe_annee->classe->niveau_id);
                foreach($Niveau_matieres as $Niveau_matiere){
                    if($classe_annee->classe->niveau_id == $Niveau_matiere->niveau_id){
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
                }

                // dd($classe);
            }
        }
        return redirect()->back();
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
