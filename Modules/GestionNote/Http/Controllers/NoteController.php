<?php

namespace Modules\GestionNote\Http\Controllers;

use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Apprenant;
use Illuminate\Http\Request;
use App\Models\ApprenantClasseAnnee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\GestionNote\Entities\Note;

use Illuminate\Contracts\Support\Renderable;
use Modules\GestionNote\Entities\Evaluation;
use Modules\Enseignement\Entities\EnseignementAnnee;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request,$type)
    {
        $annee = Annee::find(1);
        $user = Auth::user();
        $evaluations = [];
        $notes = [];
        $section_id = Section::where('id',$type)->get()[0]->id;
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        // dd($etat_section_id);
        $classes = EnseignementAnnee::where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee.classe',function($classe) use ($etat_section_id){
            $classe->where('etablissement_section_id',$etat_section_id);
        })->with('classe_annee.classe')->get();
        $evaluations = $request->classe ?  Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$user) {
            $query->where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee', function ($query1) use ($request) { 
                $query1->where('classe_id',$request->classe); 
            });
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere')->get() : collect();
        // dd($evaluations);
        // dump($classes);
        $notes = $request->evaluation ? Note::where('evaluation_id',$request->evaluation)->with('apprenant','evaluation.type_evaluation','evaluation.enseignement_annee.niveau_matiere.matiere','evaluation.periode')->get() : []; 
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
        $annee = Annee::find(1);
        $user = Auth::user();
        $section_id = Section::where('id',$request->section_id)->get()[0]->id;
        $etat_section_id = DB::table('etablissement_section')->where('section_id',$section_id)->where('etablissement_id',$user->etablissement_id)->get()[0]->id;
        // dd($etat_section_id);
        $classes = EnseignementAnnee::where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee.classe',function($classe) use ($etat_section_id){
            $classe->where('etablissement_section_id',$etat_section_id);
        })->with('classe_annee.classe')->get();
        // dd($classes);
        
        $evaluations = $request->classe ?  Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$user) {
            $query->where('enseignant_id',$user->enseignant_id)->whereHas('classe_annee', function ($query1) use ($request) { 
                $query1->where('classe_id',$request->classe); 
            });
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere')->get() : collect();
        // dd($evaluations);
        $eleves = $request->evaluation ? ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request,$annee) { 
            $query->where('classe_id',$request->classe); 
        })->with('apprenant')->get() : collect();
        // dd($eleves);
        $else =  ApprenantClasseAnnee::whereHas('classe_annee', function ($query) use ($request,$annee) { 
            $query->where('classe_id',16); 
        })->whereHas('apprenant.notes',function ($app){
            $app->where('apprenant_id',);
        })->with('apprenant')->get() ;
        // dd($else);
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
        // dd($customizingEleves);
        
       // requete pour recuperer les classes qu'un professeur intervient dans une annee donnée       
       
        // dd($customizingEleves);

        return Inertia::render('gestion-note/note/attribution',[
            'classes' => $classes,
            'evaluations'=>$evaluations,
            'eleves' => $customizingEleves ? $customizingEleves : null
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
                        'statut' => 1,
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
            'note'=>(double) $request->note
        ]);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Note modifiée avec success!',
        ]);
    }
    public function destroy($id)
    {
        //
    }
}
