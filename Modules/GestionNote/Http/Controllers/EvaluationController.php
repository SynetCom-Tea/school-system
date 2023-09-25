<?php

namespace Modules\GestionNote\Http\Controllers;

use Inertia\Inertia;
use App\Models\Section;
use App\Models\SectionUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Modules\Enseignement\Entities\Ue;
use Modules\GestionNote\Entities\Periode;
use Illuminate\Contracts\Support\Renderable;
use Modules\GestionNote\Entities\Evaluation;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\NiveauMatiere;
use Modules\GestionNote\Entities\TypeEvaluation;
use Modules\Enseignement\Entities\EnseignementAnnee;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $evaluations = Evaluation::with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.enseignant','enseignement_annee.niveau_matiere.niveau')->get();
        return Inertia::render('gestion-note/evaluation/index', [
            'evaluations'=>$evaluations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $periode = [];
        $typeEvaluations = TypeEvaluation::all();
        $enseigements = EnseignementAnnee::with('niveau_matiere.niveau.section','enseignant')->get();
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
        $matieres = $request->section_id ? DB::select("
            SELECT m.id,m.nom FROM matieres m
            JOIN etablissement_section es ON es.id = m.etablissement_section_id
            JOIN sections s ON s.id = es.section_id
            JOIN etablissements e ON e.id = es.etablissement_id
            JOIN section_users su ON es.id = su.etablissement_section_id
            JOIN users u ON u.id = su.user_id
            WHERE e.id = :etat_id AND u.id = :user_id AND s.id = :section_id
        ", [
        'etat_id' => $user->etablissement_id,
        'user_id' => $user->id,
        'section_id'=>$request->section_id
        ]):collect();
        // dd($matieres);
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
            'ues'=>$ues
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
            'pourcentage' => 'required|string|max:255',
            "enseignement_annee_id" => 'required',
            "type_evaluation_id" => 'required',
            "periode_id" => 'required',

        ]);
        $data = $request->all();
        $data = ['date' => $request->date,'pourcentage' => $request->pourcentage,'periode_id' => $request->periode_id,'type_evaluation_id' => $request->type_evaluation_id ,'enseignement_annee_id' => $request->enseignement_annee_id , 'statut' =>0?? 'RAS'];
        Evaluation::create($data);
        // dd($data);

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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        try{
            $evaluation = Evaluation::find($id);
            $evaluation->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                //dd($e->getCode());
                return redirect()->route('evaluation.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer ce besoin!",
                ]);

            }
        }

        return redirect()->route('evaluation.index')->with('message', [
            'type' => 'success',
            'text' => "Le besoin a été supprimé avec succès !",
        ]);
    }
}
