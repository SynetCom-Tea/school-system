<?php

namespace Modules\GestionNote\Http\Controllers;

use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Apprenant;
use Illuminate\Http\Request;
use App\Models\HistoriqueNote;
use App\Models\HistoriqueBulletin;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ApprenantClasseAnnee;

use Illuminate\Support\Facades\Auth;
use Modules\GestionNote\Entities\Note;
use Modules\Enseignement\Entities\Niveau;
use Modules\GestionNote\Entities\Periode;
use Modules\Enseignement\Entities\Filiere;
use Modules\Enseignement\Entities\Matiere;
use Illuminate\Contracts\Support\Renderable;
use Modules\GestionNote\Entities\Evaluation;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\GestionNote\Entities\TypeEvaluation;
use Modules\Enseignement\Entities\EnseignementAnnee;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request,$type)
    {

        $annee = Annee::max('id');
        $user = Auth::user();
        $evaluations = [];
        $notes = [];
        $section_id = Section::where('id',$type)->get()[0]->id;
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        // dd($etat_section_id);
        // $filieres = Filiere::where('etablissement_section_id',$etat_section_id);
        // dd($filieres);
        $cl =  Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees.enseignement_annees',function($classe) use($user){
            $classe->where('enseignant_id',$user->enseignant_id);
        })->whereHas('classe_annees',function($classe) use($annee){
            $classe->where('annee_id',$annee);
        })->with('niveau','cycle_filiere.filiere')->get();

        $classes = $cl->map(
            function ($value) use ($section_id){
                if($section_id>=3){
                    $code = $value->cycle_filiere->filiere->code . ' - ' . $value->niveau->code . ' - ' . $value->libelle;
                }else{
                    $code = $value->libelle;
                }
                return [
                    'id' => $value->id,
                    'code' => $code,
                ];
            }
        );
        // dd($classes);
        $ev = $request->classe ?  Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$user) {
            $query->where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee', function ($query1) use ($request) {
                $query1->where('classe_id',$request->classe);
            });
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : collect();
        $evlautaions = $request->classe ? $ev->map(
            function ($value) use ($section_id){
                if ($section_id<=2){
                    $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->niveau_matiere->matiere->nom;
                }else if ($section_id>=3){
                    if ($value->session != null){
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom .' - ' . $value->session; 
                    }else {
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom; 
                    }
                }
                return [
                    'id' => $value->id,
                    'formatEvaluationLabel' => $code,
                ];
            }
        ) : [] ;
        $notes = $request->evaluation ? Note::where('evaluation_id',$request->evaluation)->with('apprenant','evaluation.type_evaluation','evaluation.enseignement_annee.niveau_matiere.matiere','evaluation.enseignement_annee.filiere_niveau_matiere_ue.matiere','evaluation.periode')->get() : [];
        // dd($notes);
        // requete pour recuperer les classes qu'un professeur intervient dans une annee donnée
        return Inertia::render('gestion-note/note/index',[
            'type'=>$type,
            'classes' => $classes,
            'evaluations' => $evaluations,
            'notes' => $notes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function attribution(Request $request)
    {
        // dd($request->section_id);
        $evaluations = [];
        $annee = Annee::max('id');
        $user = Auth::user();
        $section_id = Section::where('id',$request->section_id)->get()[0]->id;
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        // dd($etat_section_id);
        $filieres = Filiere::where('etablissement_section_id',$etat_section_id)->whereHas('cycle_filieres.filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($user){
            $enseignant->where('enseignant_id',$user->enseignant_id);
        })->get();
        $niveaux = Niveau::where('section_id',$request->section_id)->whereHas('filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($user){
            $enseignant->where('enseignant_id',$user->enseignant_id);
        })->get();
        // dd($niveaux);
        $classes = $request->section_id >=3 && $request->niveau  ? Classe::where('etablissement_section_id',$etat_section_id)->whereHas('cycle_filiere.filiere',function($filiere) use($request){
         $filiere->where('filiere_id',$request->filiere);
        })->whereHas('classe_annees',function($classe) use($annee){
           $classe->where('annee_id',$annee);
        })->where('niveau_id',$request->niveau)->get() :  Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees.enseignement_annees',function($classe) use($user){
               $classe->where('enseignant_id',$user->enseignant_id);
             })->whereHas('classe_annees',function($classe) use($annee){
               $classe->where('annee_id',$annee);
            })->get() ;
        // dd($classes);
        $ev = $request->classe ?  Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$user) {
            $query->where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee', function ($query1) use ($request) {
                $query1->where('classe_id',$request->classe);
            });
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : collect();
        $evlautaions = $request->classe ? $ev->map(
            function ($value) use ($section_id){
                if ($section_id<=2){
                    $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->niveau_matiere->matiere->nom;
                }else if ($section_id>=3){
                    if ($value->session != null){
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom .' - ' . $value->session; 
                    }else {
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom; 
                    }
                }
                return [
                    'id' => $value->id,
                    'formatEvaluationLabel' => $code,
                ];
            }
        ) : [] ;
        // dd($evaluations);
        $apps = $request->evaluation? Note::whereHas('apprenant.apprenant_classe_annees.classe_annee',function($classeAnne) use($request){
            $classeAnne->where('classe_id',$request->classe);
        })->where('evaluation_id',$request->evaluation)->get()->pluck('apprenant_id') : collect();
        // dd($apps);
        $eleves = $request->evaluation ? ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request,$annee) {
            $query->where('classe_id',$request->classe)->where('annee_id',$annee);
        })->whereNotIn('apprenant_id',$apps)->with('apprenant')->get() : collect();
        // dd($eleves);
        $customizingEleves = $eleves->map(
            function ($value) {
                return [
                    'id' => $value->id,
                    "matricule"=>$value->apprenant->matricule,
                    "nom_complete" => $value->apprenant->nom . ' ' .  $value->apprenant->prenom,
                    "note" => 0,
                ];
            }
        );

        return Inertia::render('gestion-note/note/attribution',[
            'filieres'=>$filieres,
            'type'=>$request->section_id,
            'classes' => $classes,
            'evaluations'=>$evaluations,
            'eleves' => $customizingEleves ? $customizingEleves : null,
            'niveaux'=>$niveaux,
            // 'eleves' => $eleves ? $eleves : null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('gestionnote::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (empty($request->notes)) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'Merci de renseigner les notes!',
            ]);
        }
        if ($request->section_id >=3 && $request->enseignement_annee_id ==null && $request->evaluation ==null){
            $fnmu = FiliereNiveauMatiereUe::where('matiere_id',$request->matieres)->where('cycle_filiere_id',$request->filiere)->where('niveau_id',$request->niveau)->get();
                $classe_id = Classe::where('cycle_filiere_id',$request->filiere)->where('niveau_id',$request->niveau)->get()[0]->id;
                $enseigement_anne = EnseignementAnnee::where('filiere_niveau_matiere_ue_id',$fnmu[0]->id)->where('enseignant_id',$request->enseignant)->whereHas('classe_annee',function($classe) use ($request,$classe_id){
                    $classe->where('classe_id',$classe_id)->where('annee_id',$request->annee);
                })->where('niveau_matiere_id','=',null)->get();
                $id_enseignement = $enseigement_anne[0]->id;
                if ($request->session){
                    $evaluationId = Evaluation::where('periode_id',$request->periode_id)->where('type_evaluation_id',$request->type_evaluation_id)->where('session',$request->session)->whereHas('enseignement_annee.filiere_niveau_matiere_ue',function ($matiere) use($request){
                            $matiere->where('matiere_id',$request->matieres);
                        });
                }
                else {
                    $evaluationId = Evaluation::where('periode_id',$request->periode_id)->where('type_evaluation_id',$request->type_evaluation_id)->whereHas('enseignement_annee.filiere_niveau_matiere_ue',function ($matiere) use($request){
                        $matiere->where('matiere_id',$request->matieres);
                    });
                }
                if ($evaluationId->exists()){
                    $evaluation_id = $evaluationId->get()[0]->id;
                }else{
                    $data = ['session'=>$request->session, 'date' => $request->date,'periode_id' => $request->periode_id,'type_evaluation_id' => $request->type_evaluation_id ,'enseignement_annee_id' => $id_enseignement , 'statut' =>0?? 'RAS'];
                    $evaluation = Evaluation::create($data);
                    $evaluation_id = $evaluation->id;
                }
                // dd($evaluation_id);
        }else if ($request->section_id <=2 && $request->enseignement_annee_id !=null && $request->evaluation ==null){
            // $verifyEvaluation  = 
            $evaluationId = Evaluation::where('periode_id',$request->periode_id)->where('type_evaluation_id',$request->type_evaluation_id)->where('enseignement_annee_id',$request->enseignement_annee_id);
            if ($evaluationId->exists()){
                $evaluation_id = $evaluationId->get()[0]->id;
                // dd($evaluation_id);
            }else{
                $data = ['date' => $request->date,'periode_id' => $request->periode_id,'type_evaluation_id' => $request->type_evaluation_id ,'enseignement_annee_id' => $request->enseignement_annee_id , 'statut' =>0?? 'RAS'];
                $evaluation = Evaluation::create($data);
                $evaluation_id = $evaluation->id;
            }    
        } 
        foreach ($request->notes as $key => $value) {
            if($value != null){
                $item = ApprenantClasseAnnee::where('id',$key)->with('apprenant')->get();
                // dump($item[0]);
                $verif = Note::where('evaluation_id',$request->evaluation ? $request->evaluation : $evaluation_id )->where('apprenant_id',$item[0]->apprenant->id)->get();
                // dump($verif);
                if($verif->count() == 0){
                    $note = Note::create([
                        'apprenant_id' => $item[0]->apprenant->id,
                        'date' => date('Y-m-d'),
                        'evaluation_id' => $request->evaluation ? $request->evaluation : $evaluation_id,
                        // 'evaluation_id' => $request->evaluation,
                        'note' => (double)$value,
                        'statut' => 1
                    ]);
                }else{
                    return redirect()->back()->with('message', [
                        'type' => 'error',
                        'text' => 'Vous avez déjâ attribué des notes à ces eleves!',
                    ]);
                }
            }
        }
        // die();
        return redirect()->back()->with('message',[
            'type' => 'success',
            'text' => 'Attribution des notes bien effectué!',
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gestionnote::show');
    }
    public function update(Request $request, $id)
    {
        $note = Note::find($id);
        $note->update([
            'statut' => 0,
            'user_id'=>Auth::user()->id
        ]);
        Note::create([
            'note'=>(double) $request->note,
            'apprenant_id' => $note->apprenant->id,
            'date' => date('Y-m-d'),
            'evaluation_id' => $note->evaluation_id,
            'statut' => 1,
        ]);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Note modifiée avec success!',
        ]);
    }
    public function destroy($id)
    {
        $note = Note::find($id);
        $note->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Note supprimer avec success!',
        ]);
    }
    public function indexAdmin(Request $request)
    {
        $annee = Annee::all();
        $user = Auth::user();
        $notes = [];
        $section_id = Section::where('id',$request->section_id)->get()[0]->id;
        // dd($section_id);
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        $cl = $request->annee ? Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees',function($classe) use($request){
                  $classe->where('annee_id',$request->annee);
               })->with('niveau','cycle_filiere.filiere')->get() : [] ;
        $classes = $request->annee ? $cl->map(
            function ($value) use ($section_id){
                if($section_id>=3 && $value->cycle_filiere_id != null){
                    $code = $value->cycle_filiere->filiere->code. ' - ' . $value->niveau->code . ' - '. $value->code;
                }else{
                    $code = $value->code;
                }
                return [
                    'id'=>$value->id,
                    'code'=>$code,
                ];
            }
        ) : [];
        $ev = $request->classe ? Evaluation::whereHas('enseignement_annee.classe_annee', function ($query1) use ($request) {
            $query1->where('classe_id',$request->classe);
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : [] ;
        // dd($classes);
        $evaluations = $request->classe ?  $ev->map(
            function ($value) use ($section_id){
                if ($section_id<=2){
                    $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->niveau_matiere->matiere->nom;
                }else if ($section_id>=3){
                    if ($value->session != null){
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom .' - ' . $value->session; 
                    }else {
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom; 
                    }
                }
                return [
                    'id' => $value->id,
                    'code' => $code,
                ];
            }
        ) :[];
        $notes = $request->evaluation ? Note::where('statut',1)->where('evaluation_id',$request->evaluation)->with('apprenant','evaluation.type_evaluation','evaluation.enseignement_annee.niveau_matiere.matiere','evaluation.enseignement_annee.filiere_niveau_matiere_ue.matiere','evaluation.periode')->get() : [];
        if ($request->evaluation) {
            if ($notes->count() == 0) {
                $notes = [];
                return redirect()->back()->with('message',[
                    'type'=>'error',
                    'text'=>'Aucune note n\'est attribuée à cette évaluation'
                ]);
            }
        }
        return Inertia::render('gestion-note/note/indexAdmin',[
            'type'=>$request->section_id,
            'annees'=>$annee,
            'classes'=>$classes,
            'evaluations'=>$evaluations,
            'notes'=>$notes
        ]);
    }
    public function attributionAdmin(Request $request)
    {
        $annee = Annee::all();
        $user = Auth::user();
        $classes = [];
        $section_id = Section::where('id',$request->section_id)->get()[0]->id;
        $periodes = [];
        if($request->section_id == 1){
            $periodes = Periode::where('type',"Trimestre")->get();
        }else{
            $periodes =  Periode::where('type',"Semestre")->get();
        }
        $typeEvaluations = TypeEvaluation::all();
        // dd($section_id);
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        $enseis = Enseignant::whereHas('enseignement_annees.classe_annee.classe',function($etat) use ($etat_section_id){
            $etat->where('etablissement_section_id',$etat_section_id);
            })->where('etablissement_id',Auth::user()->etablissement_id)->get();
        $enseignant = $enseis->map(
                function ($value){
                    return [
                        'id'=>$value->id,
                        'nom_prenom'=>$value->matricule . ' - ' . $value->nom . ' - ' . $value->prenom
                    ];
                }
            );
        $cycle_filieres = $request->annee && $request->enseignant ? CycleFiliere::whereHas('filiere',function($filiere) use ($etat_section_id){
            $filiere->where('etablissement_section_id',$etat_section_id);
            })->whereHas('filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($request){
            $enseignant->where('enseignant_id',$request->enseignant);
            })->whereHas('filiere_niveau_matiere_ues.enseignement_annees.classe_annee',function($anne) use($request){
            $anne->where('annee_id',$request->annee);
            })->with('filiere','cycle')->get() : [];
        $filieres = $request->annee && $request->enseignant ? $cycle_filieres->map(
                function ($value){
                    return [
                        'id' =>$value->id,
                        'formatCode'=> $value->filiere->code . ' - ' . $value->cycle->name
                    ];
                }
            ) : [];
        $niveaux = Niveau::where('section_id',$request->section_id)->whereHas('filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($request){
            $enseignant->where('enseignant_id',$request->enseignant);
            })->get() ;
        $matieres =   $request->enseignant && $request->niveau ? Matiere::where('etablissement_section_id',$etat_section_id )->whereHas('filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($request){
            $enseignant->where('enseignant_id',$request->enseignant);
            })->whereHas('filiere_niveau_matiere_ues',function($fnmu) use ($request){
            $fnmu->where('niveau_id',$request->niveau)->where('cycle_filiere_id',$request->filiere);
            })->get()  : [];
        // $enseignement_annees = EnseignementAnne
        $enseigements = $request->classe && $request->annee && $request->section_id<=2 ?  DB::select("
            SELECT ea.id,ea.code,nm.notation FROM enseignement_annees ea
            JOIN enseignants en ON en.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id
            JOIN annees a ON a.id = ca.annee_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN niveau_matieres nm ON nm.id = ea.niveau_matiere_id
            WHERE en.id = :enseignant_id AND s.id = :section_id AND e.id = :etablissement_id AND a.id = :annee_id AND c.id = :classe_id
            ",[
                'annee_id'=>$request->annee,
                'classe_id'=>$request->classe,
                'enseignant_id'=>$request->enseignant,
                'section_id'=> $request->section_id,
                'etablissement_id'=>$user->etablissement_id
        ]):collect();
        // dd($enseigements);
        $classes = $request->annee ?  Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees.enseignement_annees',function($classe) use($request){
                $classe->where('enseignant_id',$request->enseignant);
              })->whereHas('classe_annees',function($classe) use($request){
                $classe->where('annee_id',$request->annee);
             })->get() : [];
            //  dd($classes);
        $ev = $request->classe ? Evaluation::whereHas('enseignement_annee.classe_annee', function ($query1) use ($request) {
            $query1->where('classe_id',$request->classe);
        })->whereHas('enseignement_annee',function($enseignant) use ($request){
            $enseignant->where('enseignant_id',$request->enseignant);
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : [] ;
        // dd($request->classe);
        $evaluations = $request->classe ?  $ev->map(
            function ($value) use ($section_id){
                if ($section_id<=2){
                    $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->niveau_matiere->matiere->nom;
                }else if ($section_id>=3){
                    if ($value->session != null){
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom .' - ' . $value->session; 
                    }else {
                        $code = $value->type_evaluation->libelle . ' - ' . $value->enseignement_annee->filiere_niveau_matiere_ue->matiere->nom; 
                    }
                }
                return [
                    'id' => $value->id,
                    'code' => $code,
                ];
            }
        ) :[];
        $eleves = collect();
        $apps = $request->evaluation? Note::whereHas('apprenant.apprenant_classe_annees.classe_annee',function($classeAnne) use($request){
            $classeAnne->where('classe_id',$request->classe);
        })->where('evaluation_id',$request->evaluation)->get()->pluck('apprenant_id') : collect();
        // dd($apps);
        if ($request->evaluation){
            if($request->section_id >=3){
            $eval = Evaluation::where('id',$request->evaluation)->with('enseignement_annee.filiere_niveau_matiere_ue.matiere')->get()[0];
            // dd($eval->id);
            $evaluation_session1 = Evaluation::where('periode_id',$eval->periode_id)->where('type_evaluation_id',$eval->type_evaluation_id)->where('session','Session 1')->whereHas('enseignement_annee.filiere_niveau_matiere_ue',function ($matiere) use($eval){
                $matiere->where('matiere_id',$eval->enseignement_annee->filiere_niveau_matiere_ue->matiere_id);
            });
            if ($evaluation_session1->exists() && $eval->session == 'Session 2'){
                $id_evaluation = $evaluation_session1->get()[0]->id;
                $note_apps =  Note::whereHas('apprenant.apprenant_classe_annees.classe_annee',function($classeAnne) use($request){
                    $classeAnne->where('classe_id',$request->classe);
                })->where('evaluation_id',$id_evaluation)->get()->pluck('apprenant_id');
                $id_apps = HistoriqueBulletin::where('validation',true)->get()->pluck('apprenant_id');    
                $eleves = ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request) {
                    $query->where('classe_id',$request->classe);
                })->whereNotIn('apprenant_id',$id_apps)->with('apprenant')->get();
            }else {
                $eleves = ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request) {
                    $query->where('classe_id',$request->classe);
                })->whereNotIn('apprenant_id',$apps)->with('apprenant')->get();
            }
            } else {
                $eleves = ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request) {
                    $query->where('classe_id',$request->classe);
                })->whereNotIn('apprenant_id',$apps)->with('apprenant')->get();
            }  
        }elseif($request->evaluation == null && $request->questionner == 1) {
            $eleves = ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request) {
                $query->where('classe_id',$request->classe);
            })->with('apprenant')->get();
        }
        $customizingEleves = $eleves->map(
            function ($value) {
                return [
                    'id' => $value->id,
                    "matricule"=>$value->apprenant->matricule,
                    "nom_complete" => $value->apprenant->nom . ' ' .  $value->apprenant->prenom,
                    "note" => 0,
                ];
            }
        );
        return Inertia::render('gestion-note/note/attribuationAdmin',[
            'type'=>$request->section_id,
            'annees'=>$annee,
            'enseignants'=>$enseignant,
            'classes'=>$classes,
            'evaluations'=>$evaluations,
            'eleves' => $customizingEleves ? $customizingEleves : null,
            'periodes'=>$periodes,
            'type_evaluation'=>$typeEvaluations,
            'enseignements'=> $enseigements,
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'matieres'=>$matieres
        ]);
    }
}
