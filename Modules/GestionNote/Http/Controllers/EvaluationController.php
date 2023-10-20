<?php

namespace Modules\GestionNote\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Section;
use App\Models\SectionUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Enseignement\Entities\Ue;
use Modules\Enseignement\Entities\Niveau;
use Modules\GestionNote\Entities\Periode;
use Illuminate\Contracts\Support\Renderable;
use Modules\GestionNote\Entities\Evaluation;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\NiveauMatiere;
use Modules\GestionNote\Entities\TypeEvaluation;
use Modules\Enseignement\Entities\FiliereMatiereUe;
use Modules\Enseignement\Entities\EnseignementAnnee;

class EvaluationController extends Controller
{
    public function index(Request $request,$type)
    {
        $user = Auth::user();
        $id_a = Annee::max('id');
        $enseigements = DB::select("
            SELECT ea.id,ea.code FROM enseignement_annees ea
            JOIN enseignants en ON en.id = ea.enseignant_id 
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id 
            JOIN annees a ON a.id = ca.annee_id 
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            WHERE en.id = :enseignant_id AND s.id = :section_id AND a.id = :annee_id
        ",[
            'annee_id'=>$id_a,
           'enseignant_id'=>$user->enseignant_id,
           'section_id'=>$type 
        ]);
        // dd($enseigements);
        $periodes = [];
        if($type==1){
            $periodes = Periode::where('type',"Trimestre")->get();
        }else{
            $periodes =  Periode::where('type',"Semestre")->get();
        }
        $regime = DB::table("etablissement_section")->where('etablissement_id',$user->etablissement_id)->where('section_id',$type)->get();
        $typeEvaluations = TypeEvaluation::all();
        $evaluation_primaires = DB::select("
            SELECT m.nom matiere,c.code code,e.nom enseignant,ev.date,t.libelle type,p.libelle periode,
            ev.pourcentage,t.id type_evaluation_id,p.id periode_id,ea.id enseignement_annee_id,ev.id
            FROM evaluations ev
            JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
            JOIN enseignants e ON e.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            JOIN niveau_matieres nm ON nm.id = ea.niveau_matiere_id
            JOIN niveaux n ON n.id = nm.niveau_id
            JOIN matieres m ON m.id = nm.matiere_id
            JOIN type_evaluations t ON t.id = ev.type_evaluation_id
            JOIN periodes p ON p.id = ev.periode_id
            WHERE e.id = :enseignant_id AND s.id = :section_id
        ",[
            'enseignant_id'=>$user->enseignant_id,
           'section_id'=>1
        ]);
        $evaluation_secondaires = DB::select("
            SELECT m.nom matiere,c.code code,e.nom enseignant,ev.date,t.libelle type,p.libelle periode,
            ev.pourcentage,t.id type_evaluation_id,p.id periode_id,ea.id enseignement_annee_id,ev.id
            FROM evaluations ev
            JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
            JOIN enseignants e ON e.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            JOIN niveau_matieres nm ON nm.id = ea.niveau_matiere_id
            JOIN niveaux n ON n.id = nm.niveau_id
            JOIN matieres m ON m.id = nm.matiere_id
            JOIN type_evaluations t ON t.id = ev.type_evaluation_id
            JOIN periodes p ON p.id = ev.periode_id
            WHERE e.id = :enseignant_id AND s.id = :section_id
        ",[
            'enseignant_id'=>$user->enseignant_id,
            'section_id'=>2
        ]);
        // dd($evaluation_secondaires);
        $evaluation_superieures = DB::select("
            SELECT m.nom matiere,c.code code,e.nom enseignant,ev.date,t.libelle type,p.libelle periode,
            ev.pourcentage,t.id type_evaluation_id,p.id periode_id,ea.id enseignement_annee_id,ev.id
            FROM evaluations ev
            JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
            JOIN enseignants e ON e.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            JOIN filiere_niveau_matiere_ues fnmu ON fnmu.id = ea.filiere_niveau_matiere_ue_id
            JOIN matieres m ON m.id = fnmu.matiere_id
            JOIN type_evaluations t ON t.id = ev.type_evaluation_id
            JOIN periodes p ON p.id = ev.periode_id
            WHERE e.id = :enseignant_id AND s.id = :section_id
        ",[
            'enseignant_id'=>$user->enseignant_id,
           'section_id'=>3
        ]);
        $evaluation_universites = DB::select("
        SELECT m.nom matiere,c.code code,e.nom enseignant,ev.date,t.libelle type,p.libelle periode,
        ev.pourcentage,t.id type_evaluation_id,p.id periode_id,ea.id enseignement_annee_id,ev.id id
        FROM evaluations ev
        JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
        JOIN enseignants e ON e.id = ea.enseignant_id
        JOIN classe_annees ca ON ca.id = ea.classe_annee_id
        JOIN classes c ON c.id = ca.classe_id
        JOIN etablissement_section es ON es.id = c.etablissement_section_id
        JOIN sections s ON s.id = es.section_id
        JOIN filiere_niveau_matiere_ues fnmu ON fnmu.id = ea.filiere_niveau_matiere_ue_id
        JOIN matieres m ON m.id = fnmu.matiere_id
        JOIN type_evaluations t ON t.id = ev.type_evaluation_id
        JOIN periodes p ON p.id = ev.periode_id
        WHERE e.id = :enseignant_id AND s.id = :section_id
    ",[
        'enseignant_id'=>$user->enseignant_id,
       'section_id'=>4
    ]);
        return Inertia::render('gestion-note/evaluation/index', [
            'evaluation_primaires'=>$evaluation_primaires,
            'evaluation_secondaires'=>$evaluation_secondaires,
            'evaluation_superieures'=>$evaluation_superieures,
            'evaluation_universites'=>$evaluation_universites,
            'types'=>$type,
            'periodes'=>$periodes,
            'type_evaluation'=>$typeEvaluations,
            'regime'=>$regime,
            'enseignements'=>$enseigements 
        ]);
    }

    public function indexAdmin(Request $request)
    {
        $evaluations = [];
        $evaluation_id  = null;
        $detail = [];
        $user = Auth::user();
        $sections = Section::whereHas('etablissements.users', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->get(); 
        // dd($sections);
        $enseigements = $request->enseignant_id ?  DB::select("
        SELECT ea.id,ea.code FROM enseignement_annees ea
        JOIN enseignants en ON en.id = ea.enseignant_id 
        JOIN classe_annees ca ON ca.id = ea.classe_annee_id
        JOIN classes c ON c.id = ca.classe_id 
        JOIN annees a ON a.id = ca.annee_id 
        JOIN etablissement_section es ON es.id = c.etablissement_section_id
        JOIN sections s ON s.id = es.section_id
        JOIN etablissements e ON e.id = es.etablissement_id
        WHERE en.id = :enseignant_id AND s.id = :section_id AND e.id = :etablissement_id
        ",[
           'enseignant_id'=>$request->enseignant_id,
           'section_id'=> $request->section_id,
           'etablissement_id'=>$user->etablissement_id
        ]):collect();
        
        // dd($enseigements);
        $periodes = [];
        if($request->section_id == 1){
            $periodes = Periode::where('type',"Trimestre")->get();
        }else{
            $periodes =  Periode::where('type',"Semestre")->get();
        }
        $typeEvaluations = TypeEvaluation::all();
        if ($request->evaluation_id){
            $evaluation_id = $request->evaluation_id;
            if(Evaluation::getDetailEvaluationInferiere(Auth::user()->etablissement_id,$request->evaluation_id)->get()){
                $detail = Evaluation::getDetailEvaluationInferiere(Auth::user()->etablissement_id,$request->evaluation_id)->get();
            }else{
                $detail = Evaluation::getDetailEvaluationSuperieur(Auth::user()->etablissement_id,$request->evaluation_id)->get();
            }
        } 
        $enseignants = Enseignant::where('etablissement_id',Auth::user()->etablissement_id)->get();    
        if ($request->section_id >=3){
        $evaluations = DB::select("
            SELECT m.nom,s.libelle section,ev.id,p.libelle,en.nom,ev.date,t.libelle type,ea.code,
            s.id section_id,en.id enseignant_id,t.id type_evaluation_id,p.id periode_id,ea.id enseignement_annee_id
            FROM evaluations ev
            JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
            JOIN enseignants en ON en.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN sections s ON s.id = es.section_id
            JOIN type_evaluations t ON t.id = ev.type_evaluation_id
            JOIN periodes p ON p.id = ev.periode_id
            JOIN niveau_matieres nm ON nm.id = ea.niveau_matiere_id
            JOIN filiere_matiere_ues fmu ON fmu.id = nm.filiere_matiere_ue_id
            JOIN matieres m ON m.id = fmu.matiere_id
            WHERE e.id = :etablissement_id AND s.id = :section_id
            ",[
                'etablissement_id' => Auth::user()->etablissement_id,
                'section_id'=>$request->section_id
        ]);
        // dd('sup');
        }else{
        $evaluations = DB::select("
            SELECT m.nom matiere,s.libelle section,ev.id,p.libelle,en.nom,ev.date,t.libelle type,ea.code,
            s.id section_id,en.id enseignant_id,t.id type_evaluation_id,p.id periode_id,ea.id enseignement_annee_id
            FROM evaluations ev
            JOIN enseignement_annees ea ON ea.id = ev.enseignement_annee_id
            JOIN enseignants en ON en.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN classes c ON c.id = ca.classe_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN sections s ON s.id = es.section_id
            JOIN type_evaluations t ON t.id = ev.type_evaluation_id
            JOIN periodes p ON p.id = ev.periode_id
            JOIN niveau_matieres nm ON nm.id = ea.niveau_matiere_id
            JOIN matieres m ON m.id = nm.matiere_id
            WHERE e.id = :etablissement_id AND s.id = :section_id
            ",[
                'etablissement_id' => Auth::user()->etablissement_id,
                'section_id'=>$request->section_id
            ]);
            // dd('in');
        }
        // dd($evaluations);
        return Inertia::render('gestion-note/evaluation/indexAdmin',[
            'evaluations'=> $evaluations,
            'details'=>$detail,
            'periodes'=>$periodes,
            'type_evaluation'=>$typeEvaluations,
            'enseignements'=>$enseigements,
            'section'=>$sections,
            'enseignants'=>$enseignants,
            'evaluation_id'=> $evaluation_id,
            'section_id'=>$request->section_id
        ]);
    }
    public function create(Request $request)
    {
        $annee_id = Annee::latest()->get();
        $libelle = $annee_id[0]->libelle;
        $user = Auth::user();
        $periode = [];
        $typeEvaluations = TypeEvaluation::all();
        $enseigements = '';
        // RECUPERATION DES SECTIONS AUXQUELLES LES ENSEIGNANTs ONT ETE AFFECTE EN FONCTION DE L'ETABLISSEMENT DE
        // l'ENSEIGNANT
        $sections = DB::select("
            SELECT s.id,s.libelle FROM sections s
            JOIN etablissement_section es ON s.id = es.section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN section_users su ON es.id = su.etablissement_section_id
            JOIN users u ON u.id = su.user_id
            WHERE e.id = :etat_id AND u.id = :user_id
        ", [
            'etat_id' => $user->etablissement_id,
            'user_id' => $user->id,
        ]) ;
        $matieres = DB::select("
            SELECT m.id,m.nom FROM matieres m
            JOIN etablissement_section es ON es.id = m.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN section_users su ON es.id = su.etablissement_section_id
            JOIN users u ON u.id = su.user_id
            JOIN filiere_matiere_ues fmu ON m.id = fmu.matiere_id
            JOIN niveau_matieres nm ON fmu.id = nm.filiere_matiere_ue_id
            JOIN enseignement_annees ea ON nm.id = ea.niveau_matiere_id
            JOIN enseignants en ON en.id = ea.enseignant_id
            JOIN classe_annees ca ON ca.id = ea.classe_annee_id
            JOIN annees a ON a.id = ca.annee_id 
            WHERE e.id = :etat_id AND u.id = :user_id AND s.id = :section_id AND en.id = :enseignant_id AND a.libelle = :libelle
        ", [
        'etat_id' => $user->etablissement_id,
        'user_id' => $user->id,
        'section_id'=>2,
        'libelle'=>$libelle,
        'enseignant_id'=>$user->enseignant_id
        ]);
        // dd($matieres);
        $classes = $request->niveau_id ? DB::select("
            SELECT c.id,c.code FROM classes c
            JOIN niveaux n ON n.id = c.niveau_id
            JOIN etablissement_section es ON es.id = c.etablissement_section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN sections s ON s.id = es.section_id
            WHERE s.id = :section_id AND e.id = :etat_id AND n.id = :niveau_id
        ",[
            'etat_id' => $user->etablissement_id,
            'section_id'=>$request->section_id,
            'niveau_id'=> $request->niveau_id
        ]): collect();
        // dd($classes);
        $niveaux = $request->section_id ? Niveau::where('section_id',$request->section_id)->get():collect();
        $cycle_filieres = CycleFiliere::whereHas('filiere',function ($q)use  ($user){
            $q->where('etablissement_id',$user->etablissement_id);
        })->get();
        // dd($cycle_filieres);
        $ues = Ue::where('etablissement_id',$user->etablissement_id)->get();
        // dd($ues);
        if ($request->section_id == 1) {
            $periode = $request->section_id ? Periode::where('type',"Trimestre")->get():collect();
        }else {
            $periode = $request->section_id ? Periode::where('type',"Semestre")->get():collect();
        }
        $enseignant = Enseignant::where('etablissement_id',Auth::user()->etablissement_id)->get();
        return Inertia::render('gestion-note/evaluation/create', [
            'periodes'=>$periode,
            'typeEvaluations'=>$typeEvaluations,
            'enseigements'=>$enseigements,
            'sections'=>$sections,
            'nivau_matieres'=>NiveauMatiere::all(),
            'enseignant'=>$enseignant,
            'matieres'=>$matieres,
            'cycle_filieres'=>$cycle_filieres,
            'ues'=>$ues,
            'niveaux'=>$niveaux,
            'classes'=>$classes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request);
        request()->validate([
            'date' => 'required|date',
            "enseignement_annee_id" => 'required',
            "type_evaluation_id" => 'required',
            "periode_id" => 'required',

        ]);
        $data = $request->all();
        $data = ['date' => $request->date,'pourcentage' => $request->pourcentage,'periode_id' => $request->periode_id,'type_evaluation_id' => $request->type_evaluation_id ,'enseignement_annee_id' => $request->enseignement_annee_id , 'statut' =>0?? 'RAS'];
        Evaluation::create($data);
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

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('gestionnote::edit');
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
        $evaluation = Evaluation::find($id);
        $evaluation->update($request->all());
    }
    
    public function destroy(string $id)
    { 
        $evaluation = Evaluation::find($id);
        // dd($evaluation);
        $evaluation->delete(); 
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => "L'evaluation supprimé avec succès !",
        ]);
    }
}
