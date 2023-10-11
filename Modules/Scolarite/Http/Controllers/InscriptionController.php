<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Modules\Scolarite\Entities\Inscription;
use App\Models\Annee;
use App\Models\Apprenant;
use App\Models\Classe;
use App\Models\ClasseAnnee;
use App\Models\TypeDocument;
use App\Models\Document;
use App\Models\ApprenantClasseAnnee;
use App\Models\ApprenantTuteur;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\Tuteur;
use Modules\Scolarite\Entities\TypeFrais;
use Modules\Scolarite\Entities\Versement;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // dd('r:', $request->all());
        try {
            //code...

            if (Auth::user() == null) {

                return redirect('/login')->with('message', [
                    'type' => 'error',
                    'text' => 'Session ou Token expiré!',
                ]);
            }

            return Inertia::render('Inscription/Index', [
                'vSectionID' => (int)$request->section_id
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => $th,
            ]);
        }
    }

    public function addPage(Request $request)
    {
        // dd($request);
        $apprenant = json_decode($request->query('apprenant'));
        $section = json_decode($request->query('section'));
        // dd($apprenant,$section);
        // dd($request->apprenant);
        return Inertia::render('Inscription/Create', [
            'type' => $section,
            'niveaux' => Niveau::where('section_id', $section)->get(),
            'typeFrais' => TypeFrais::all(),
            'apprenant' => $apprenant,
            'annees' => Annee::all(),
            'typeDocuments' => TypeDocument::all(),
            'tuteurs' => ApprenantTuteur::whereHas('apprenant', function($query){$query->where('etablissement_id',Auth::user()->etablissement_id);})->with('tuteur')->get()
        ]);
    }

    // requete AXIOS pour verifier voir si ya au moins une classe pour ce niveau
    public function getFrais($niveau)
    {
        // dd($niveau);
        $frais_scolarite = 0;
        $frais = Frais::where('type_frais_id',2)->where('annee_id',2)->where('etablissement_id',Auth::user()->etablissement_id)->where('niveau_id',$niveau)->first();
        if($frais){
            $frais_scolarite = $frais->montant;
        }
        // dd($frais_scolarite);
        return $frais_scolarite;
    }
    
    // requete AXIOS pour verifier voir si ya au moins une classe pour ce niveau
    public function checkClasse($niveau,$etabSection)
    {
        // dd($niveau,$etabSection);
        $donnees = [];
        $tabs = [];
        $result = ClasseAnnee::whereHas('classe', function ($query) use ($niveau,$etabSection){
            $query->where('niveau_id',$niveau)->where('etablissement_section_id',$etabSection);
        })->with('classe.niveau')->get();

        foreach($result as $key => $item){
            $nbre = ApprenantClasseAnnee::where('classe_annee_id',$item->id)->count();
            $tabs = [
                'classe' => $item,
                'nbre' => $nbre
            ];
            $donnees[$key] = $tabs;
        }
        // dd($donnees);
        return $donnees ?? [];
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Apprenant
        $id_apprenant = null;

        $type_frais = TypeFrais::where('libelle','Frais de scolarité')->first();
        $frais = Frais::where('type_frais_id',$type_frais->id)->where('annee_id',$request->annees['annee'])->where('niveau_id',$request->annees['niveau'])
        ->where('etablissement_id',Auth::user()->etablissement_id)->first();
        // dd($frais);
        if($frais == null){
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'frais de scolarité manquants',
            ]);
        }
        if($request->apprenants){
            $find = Apprenant::where('nom',$request->apprenants['nom'])->where('prenom',$request->apprenants['prenom'])->where('sexe',$request->apprenants['sexe'])
            ->where('date_naissance',$request->apprenants['date_naissance'])->where('lieu_naissance',$request->apprenants['lieu_naissance'])->where('telephone',$request->apprenants['telephone'])
            ->where('etablissement_id',Auth::user()->etablissement_id)->first();
            if($find == null){
                $item_apprenant = Apprenant::create([
                    'nom' => $request->apprenants['nom'],
                    'prenom' => $request->apprenants['prenom'],
                    'sexe' => $request->apprenants['sexe'],
                    'date_naissance' => $request->apprenants['date_naissance'],
                    'lieu_naissance' => $request->apprenants['lieu_naissance'],
                    'telephone' => $request->apprenants['telephone'],
                    'etablissement_id' => Auth::user()->etablissement_id
                ]);
                $id_apprenant = $item_apprenant->id;
            }else{
                $id_apprenant = $find->id;
            }
        }else{
            $id_apprenant = $request->annees['apprenant']['more']['apprenant']['id'];
        }
        // dd($id_apprenant);

        // Inscription
        $check = Inscription::where('annee_id',$request->annees['annee'])->where('apprenant_id',$id_apprenant)->get();
        if($check->count() == 0){
            $inscription = Inscription::create([
                'date_inscription' => date('Y-m-d'),
                'annee_id' => $request->annees['annee'],
                'niveau_id' => $request->annees['niveau'],
                'apprenant_id' => $id_apprenant
            ]);
        }else{
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'Cette inscription existe déjà',
            ]);
        }

        $classe = null;
        if($request->annees['classe'] == null){
            $niv = Niveau::find($request->annees['niveau'])->code;
            $cl = Classe::create([
                'code' => $niv.' A',
                'libelle' => $niv.' A',
                'niveau_id' => $request->annees['niveau'],
                'etablissement_section_id' => $request->annees['etablissement_section_id']['id']
            ]);
            $classe = $cl->id;
        }else{
            $classe = $request->annees['classe'];
        }


        $checkAnneeClasse = ClasseAnnee::where('annee_id',$request->annees['annee'])->where('classe_id',$classe)->first();
        $classe_annee = null;
        if($checkAnneeClasse == null){
            $classe_annee = ClasseAnnee::create([
                'annee_id' => $request->annees['annee'],
                'classe_id' => $classe
            ]);
        }else{
            $classe_annee = $checkAnneeClasse;
        }


        ApprenantClasseAnnee::create([
            'classe_annee_id' => $classe_annee->id,
            'apprenant_id' => $id_apprenant
        ]);

        // Versement

        
        Versement::create([
            'inscription_id' => $inscription->id,
            'frais_id' => $frais->id,
            'montant' => $request->annees['versement'],
            'date_versement' => date('Y-m-d')
        ]);

        // Tuteur
        if($request->tuteurs){
            if($request->tuteurs['selection'] !== '1'){
                foreach($request->tuteurs['tuteurs'] as $tuteur){
                    $item_tuteur = Tuteur::create([
                        'nom' => $tuteur['nom'],
                        'prenom' => $tuteur['prenom'],
                        'telephone' => $tuteur['tel'],
                        // 'adresse' => $tuteur['adresse'],
                        'email' => $tuteur['email'],
                        'sexe' => $tuteur['sexe'],
                    ]);
                    ApprenantTuteur::create([
                        'apprenant_id' => $id_apprenant,
                        'tuteur_id' => $item_tuteur['id'],
                    ]);
                }
            }else{
                for($i = 0; $i < count($request->tuteurs['selectTuteurs']); $i++){
                    ApprenantTuteur::create([
                        'apprenant_id' => $id_apprenant,
                        'tuteur_id' => $request->tuteurs['selectTuteurs'][$i],
                    ]);
                }
            }
        }
        if($request->documents){
            foreach($request->documents['documents'] as $document){
                $file_name = $document['file'][0] ? $document['file'][0]->getClientOriginalName() : null;
                $document['file'][0] && $document['file'][0]->move('test/', $document['file'][0]->getClientOriginalName());
           
                $item_tuteur = Document::create([
                    'type_document_id' => $document['type'],
                    'apprenant_id' => $id_apprenant,
                    'file' => $file_name,
                ]);
            }
        }

        

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Inscription effectuée avec succès',
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('scolarite::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scolarite::edit');
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
