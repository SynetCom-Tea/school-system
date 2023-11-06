<?php

namespace Modules\GestionNote\Http\Controllers;

use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Apprenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ApprenantClasseAnnee;
use Illuminate\Support\Facades\Auth;
use Modules\GestionNote\Entities\Note;

use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Filiere;
use Illuminate\Contracts\Support\Renderable;
use Modules\GestionNote\Entities\Evaluation;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\EnseignementAnnee;

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
        $classes =  Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees.enseignement_annees',function($classe) use($user){
            $classe->where('enseignant_id',$user->enseignant_id);
        })->whereHas('classe_annees',function($classe) use($annee){
            $classe->where('annee_id',$annee);
        })->with('niveau','cycle_filiere.filiere')->get();
        // dd($classes);
        $evaluations = $request->classe ?  Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$user) {
            $query->where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee', function ($query1) use ($request) { 
                $query1->where('classe_id',$request->classe); 
            });
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : collect();
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
        $evaluations = $request->classe ?  Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$user) {
            $query->where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee', function ($query1) use ($request) { 
                $query1->where('classe_id',$request->classe); 
            });
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : collect();
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
        // dd($request->notes);
        foreach ($request->notes as $key => $value) {
            if($value != null){
                $item = ApprenantClasseAnnee::where('id',$key)->with('apprenant')->get();
                // dump($item[0]);
                $verif = Note::where('evaluation_id',$request->evaluation)->where('apprenant_id',$item[0]->apprenant->id)->get();
                // dump($verif);
                if($verif->count() == 0){
                    $note = Note::create([
                        'apprenant_id' => $item[0]->apprenant->id,
                        'date' => date('Y-m-d'),
                        'evaluation_id' => $request->evaluation,
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
        return redirect()->back()->with('message', [
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
        $classes = $request->annee ? Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees',function($classe) use($request){
                  $classe->where('annee_id',$request->annee);
               })->with('niveau','cycle_filiere.filiere')->get() : [] ; 
        $evaluations = $request->classe ? Evaluation::whereHas('enseignement_annee.classe_annee', function ($query1) use ($request) { 
            $query1->where('classe_id',$request->classe); 
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : [] ;
        $notes = $request->evaluation ? Note::where('statut',1)->where('evaluation_id',$request->evaluation)->with('apprenant','evaluation.type_evaluation','evaluation.enseignement_annee.niveau_matiere.matiere','evaluation.enseignement_annee.filiere_niveau_matiere_ue.matiere','evaluation.periode')->get() : []; 
        if ($request->evaluation) {
            if ($notes->count() == 0) {
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
        // dd($section_id);
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        $enseignant = Enseignant::where('etablissement_id',Auth::user()->etablissement_id)->get(); 
        // Cycle filieres
        $filieres = $request->enseignant ? CycleFiliere::whereHas('filiere',function($filiere) use ($etat_section_id){
            $filiere->where('etablissement_section_id',$etat_section_id);
        })->whereHas('filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($request){
            $enseignant->where('enseignant_id',$request->enseignant);
        })->with('filiere','cycle')->get() : [];
        // dd($filieres);
        // Niveaux
        $niveaux = Niveau::where('section_id',$request->section_id)->whereHas('filiere_niveau_matiere_ues.enseignement_annees.enseignant',function($enseignant) use($request){
            $enseignant->where('enseignant_id',$request->enseignant);
        })->get() ;
        // dd($niveaux);
        // Classes
        if ($request->section_id >=3 && $request->niveau){
            $classes = Classe::where('etablissement_section_id',$etat_section_id)->whereHas('cycle_filiere.filiere',function($filiere) use($request){
                $filiere->where('filiere_id',$request->filiere);
               })->whereHas('classe_annees',function($classe) use($request){
                  $classe->where('annee_id',$request->annee);
               })->where('niveau_id',$request->niveau)->get();
        } elseif ($request->annee && $request->section_id <=2) {
          $classes =   Classe::where('etablissement_section_id',$etat_section_id)->whereHas('classe_annees.enseignement_annees',function($classe) use($request){
                $classe->where('enseignant_id',$request->enseignant);
              })->whereHas('classe_annees',function($classe) use($request){
                $classe->where('annee_id',$request->annee);
             })->get();
            //  dd($classes);
        }
        $evaluations = $request->classe ? Evaluation::whereHas('enseignement_annee.classe_annee', function ($query1) use ($request) { 
            $query1->where('classe_id',$request->classe); 
        })->whereHas('enseignement_annee',function($enseignant) use ($request){
            $enseignant->where('enseignant_id',$request->enseignant);
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.filiere_niveau_matiere_ue.matiere')->get() : [] ;
        // dd($request->classe);

        $apps = $request->evaluation? Note::whereHas('apprenant.apprenant_classe_annees.classe_annee',function($classeAnne) use($request){
            $classeAnne->where('classe_id',$request->classe);
        })->where('evaluation_id',$request->evaluation)->get()->pluck('apprenant_id') : collect();
        // dd($apps);
        $eleves = $request->evaluation ? ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request) { 
            $query->where('classe_id',$request->classe); 
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
        return Inertia::render('gestion-note/note/attribuationAdmin',[
            'type'=>$request->section_id,
            'annees'=>$annee,
            'enseignants'=>$enseignant,
            'classes'=>$classes,
            'evaluations'=>$evaluations,
            'eleves' => $customizingEleves ? $customizingEleves : null,
            'filieres'=>$filieres,
            'niveaux'=>$niveaux
        ]);
    }
}
