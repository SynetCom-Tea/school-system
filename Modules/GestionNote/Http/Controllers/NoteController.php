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
        })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere')->get() : collect();
        //  dd($evaluations);
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

        $eleves = $request->evaluation ? ApprenantClasse::whereHas('classe_annee', function ($query) use ($request,$annee) { 
            $query->where('classe_id',$request->classe)->where('annee_id', $annee->id); 
        })->with('apprenant')->get() : collect();

        $customizingEleves = $eleves->map(
            function ($value) {
                return [
                    'id' => $value->id,
                    "nom" => $value->apprenant->nom,
                    "prenom" => $value->apprenant->prenom,
                    "nom_complete" => $value->apprenant->nom_complete,
                    "note" => 0,
                ];
            }
        );
        
       // requete pour recuperer les classes qu'un professeur intervient dans une annee donnée       
       
        // dd($customizingEleves);

        return Inertia::render('gestion-note/note/attribution',[
            'classes' => EnseignementAnnee::whereHas('classe_annee', function ($query) use ($annee) {
                $query->where('annee_id', $annee->id);
            })->where('enseignant_id',1)->with('classe_annee.classe')->get(),
            'evaluations' => $evaluations = $request->classe ? Evaluation::whereHas('enseignement_annee', function ($query) use ($request,$annee) {
                $query->where('enseignant_id',1)->whereHas('classe_annee', function ($query1) use ($request,$annee) { 
                    $query1->where('classe_id',$request->classe)->where('annee_id', $annee->id); 
                });
            })->with('type_evaluation','periode','enseignement_annee.niveau_matiere.matiere')->get() : []
            ,
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
        // dd($request->notes);
        // $data = $this->validate($request, [
        //     'evaluation' => 'required',
        //     'notes' => 'required',
        // ]);
        if (empty($request->notes)) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'Merci de renseigner les notes!',
            ]);
        }
        foreach ($request->notes as $key => $value) {
            
            // die();
            if($value != null){
            //     dump('key',$key);
            // dump('value',$value);
                # code...
                $item = ApprenantClasse::where('id',$key)->with('apprenant')->first();
                // dump($item);
                $verif = Note::where('evaluation_id',1)->where('apprenant_id',$item->apprenant->id)->get();
                // dd($verif,$verif->count());
                if($verif->count() == 0){
                    $note = Note::create([
                        'apprenant_id' => $item->apprenant->id,
                        'date' => date('Y-m-d'),
                        'evaluation_id' => 1,
                        // 'evaluation_id' => $request->evaluation,
                        'note' => (double)$value,
                        'statut' => 1,
                    ]);
                }else{
                    return redirect()->back()->with('message', [
                        'type' => 'error',
                        'text' => 'Merci de renseigner toutes les notes!',
                    ]);
                } 
            } 
        }
        // die();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Sauvegarde de notes réussie avec succès!',
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
