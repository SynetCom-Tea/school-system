<?php

namespace Modules\GestionNote\Http\Controllers;

use Modules\GestionNote\Entities\Periode;
use Modules\GestionNote\Entities\TypeEvaluation;
use Modules\GestionNote\Entities\Evaluation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Inertia\Inertia;
use Modules\GestionNote\Entities\Enseignant;
use Modules\GestionNote\Entities\EnseignementAnnee;
use Modules\GestionNote\Entities\Matiere;
use Modules\GestionNote\Entities\Niveau;
use Modules\GestionNote\Entities\NiveauMatiere;
use Modules\GestionNote\Entities\Section;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $evaluations = Evaluation::with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere','enseignement_annee.enseignant','enseignement_annee.niveau_matiere.niveau')->get();

        // dd($evaluations);
        $periodes = Periode::all();
        $typeEvaluations = TypeEvaluation::all();
        $enseigements= EnseignementAnnee::with('niveau_matiere.niveau.section','enseignant')->get();
        // dd($enseigements);
        $sections= Section::all();
        $nivau_matieres= NiveauMatiere::all();
        $enseignant= Enseignant::all();
        return Inertia::render('gestion-note/evaluation/index', [
            'evaluations'=>$evaluations,
            'periodes'=>$periodes,
            'typeEvaluations'=>$typeEvaluations,
            'enseigements'=>$enseigements,
            'sections'=>$sections,
            'nivau_matieres'=>$nivau_matieres,
            'enseignant'=>$enseignant,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return Inertia::render('gestion-note/evaluation/index', [

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
