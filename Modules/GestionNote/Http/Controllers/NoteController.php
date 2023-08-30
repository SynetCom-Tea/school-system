<?php

namespace Modules\GestionNote\Http\Controllers;

use Modules\GestionNote\Entities\Apprenant;
use Modules\GestionNote\Entities\Classe;
use Modules\GestionNote\Entities\Note;
use Modules\GestionNote\Entities\Annee;
use Modules\GestionNote\Entities\Evaluation;
use Modules\GestionNote\Entities\EnseignementAnnee;
use Modules\GestionNote\Entities\ApprenantClasse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $annee = Annee::find(1);
        $notes = $request->evaluation ? Note::where('evaluation_id',$request->evaluation)
        ->with('apprenant','evaluation.type_evaluation','evaluation.periode')->get() : []; 
        // requete pour recuperer les classes qu'un professeur intervient dans une annee donnée       
        $evaluations = $request->classe ? Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$annee) {
            $query->where('enseignant_id',1)->whereHas('classe_annee', function ($query1) use ($request,$annee) { 
                $query1->where('classe_id',$request->classe)->where('annee_id', $annee->id); 
            });
        })->with('type_evaluation','periode')->get() : collect();
        // dd($notes);
        return Inertia::render('gestion-note/note/index',[
            'classes' => EnseignementAnnee::whereHas('classe_annee', function ($query) use ($annee) {
                $query->where('annee_id', $annee->id);
            })->where('enseignant_id',1)->with('classe_annee.classe')->get(),
            'evaluations' => $evaluations ? $evaluations : null,
            'notes' => $notes ? $notes : null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function attribution(Request $request)
    {
        // dd('ok');
        $annee = Annee::find(1);

        $eleves = $request->evaluation ? ApprenantClasse::whereHas('enseignement_annee', function ($query) use ($request,$annee) {
            $query->where('enseignant_id',1)->whereHas('classe_annee', function ($query1) use ($request,$annee) { 
                $query1->where('classe_id',1)->where('annee_id', $annee->id); 
            });
        })->with('apprenant')->get() : collect();
        
       // requete pour recuperer les classes qu'un professeur intervient dans une annee donnée       
       
        dd($eleves);

        return Inertia::render('gestion-note/note/attribution',[
            'classes' => EnseignementAnnee::whereHas('classe_annee', function ($query) use ($annee) {
                $query->where('annee_id', $annee->id);
            })->where('enseignant_id',1)->with('classe_annee.classe')->get(),
            'evaluations' => ['Interrogation','Devoir','Composition'],
            'notes' => $notes ? $notes : null
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
        //
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
