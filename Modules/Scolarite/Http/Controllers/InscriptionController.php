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
use App\Models\Cycle;
use Modules\Enseignement\Entities\CycleFiliere;
use App\Models\TypeDocument;
use App\Models\Document;
use App\Models\ApprenantClasseAnnee;
use App\Models\Etablissement;
use App\Models\ApprenantTuteur;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\Tuteur;
use Modules\Scolarite\Entities\TypeFrais;
use Modules\Scolarite\Entities\Versement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Scolarite\Entities\EtablissementTypeDocument;

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
                'vSectionID' => (int)$request->section_id,
                'inscriptions' => $this->ajaxInscriptionListe($request,null,$request->section_id)
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
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $section);
        // dd($apprenant,$section);
        // dd($request->apprenant);
        return Inertia::render('Inscription/Create', [
            'type' => $section,
            'niveaux' => Niveau::where('section_id', $section)->get(),
            'cycles' => Cycle::all(),
            'cycleFilieres' => CycleFiliere::whereHas('filiere', function($query) use ($section, $etablissement_section){
                $query->where('etablissement_section_id',$etablissement_section)->where(function ($query) use ($section) {
                    if($section == '3'){
                        return $query->where('departement_id',null);
                    } elseif($section == '4') {
                        return $query->where('departement_id','<>',null);
                    }
                });
            })->where('cycle_id',$request->cycle_id ? $request->cycle_id : 1)->with('filiere','cycle')->get(),
            'typeFrais' => TypeFrais::all(),
            'apprenant' => $apprenant,
            'annees' => Annee::all(),
            'typeDocuments' => EtablissementTypeDocument::where('etablissement_section_id',$etablissement_section)->where('statut','1')->with('type_document')->get(),
            'tuteurs' => ApprenantTuteur::whereHas('apprenant', function($query){$query->where('etablissement_id',Auth::user()->etablissement_id);})->with('tuteur')->get()
        ]);
    }

    // Debut requete AXIOS 
    public function ajaxInscriptionListe(Request $request,$mat = null,$sec = null)
    {
        // dd($request->nom);
        $nom = null;
        $prenom = null;
        
        $section = $sec ? $sec : $request->section;
        $matricule = null;
        if($request->matricule == null && $mat == null){
            $nom = $request->nom;
            $prenom = $request->prenom;
        }elseif($request->matricule != null && $mat == null){
            $matricule = $request->matricule;
        }
        $list = [];
        $authUser =  Auth::user();
        $collection = collect();
        $nameRole = $authUser->roles[0] ? $authUser->roles[0]->name : null;
        // $findNiveau = Niveau::where('section_id', (int)$section)->where('id', (int)$niveau)->get();
        // $year = Annee::where('actif',1)->first()->id;
        $year = getAnneeEncours()->id;
        // dd($params,$year);
        
            
           
            if ($nameRole == 'Administrateur') {
                $list = Inscription::where(function ($query) use ($section) {
                    if($section == '1' || $section == '2'){
                        return $query->where('cycle_filiere_id',null);
                    } elseif($section == '3') {
                        return $query->where('cycle_filiere_id','<>',null)->whereHas('cycleFiliere', function($query) use ($section) {
                            $query->whereHas('filiere', function($query) use ($section){
                                $query->where('etablissement_id',Auth::user()->etablissement_id)->where(function ($query) use ($section) {
                                    if($section == '3'){
                                        return $query->where('departement_id',null);
                                    } elseif($section == '4') {
                                        return $query->where('departement_id','<>',null);
                                    }
                                });
                            });
                        });
                    }elseif($section == '4'){
                        return $query->where('cycle_filiere_id','<>',null)->whereHas('cycleFiliere', function($query) use ($section) {
                            $query->whereHas('filiere', function($query) use ($section){
                                $query->where('etablissement_id',Auth::user()->etablissement_id)
                                ->where(function ($query) use ($section) {
                                    if($section == '3'){
                                        return $query->where('departement_id',null);
                                    } elseif($section == '4') {
                                        return $query->where('departement_id','<>',null);
                                    }
                                });
                            });
                        });
                    }
                })->where(function ($query) use ($section,$matricule,$year,$nom,$prenom) {
                    if($matricule !== null || $nom !== null || $prenom !== null){
                       
                    }else{
                        $query->where('annee_id',$year);
                    }
                })
                ->whereHas('apprenant', function ($query) use ($authUser,$matricule,$nom,$prenom) {
                    if($matricule !== null){
                        $query->where('matricule','like', '%' . $matricule . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                        // dump('matricule',$matricule);
                    }elseif($nom != null && $prenom != null){
                        $query->where('nom','like', '%' . $nom . '%')->where('prenom','like', '%' . $prenom . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                    }else{
                        $query->where('nom','like', '%' . $nom . '%')->orWhere('prenom','like', '%' . $prenom . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                    }
                    // else{
                    //     $query->where('nom', 'like', '%' . $nom . '%')->orWhere('prenom', 'like', '%' . $prenom . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                    //     // dump('non matricule');
                    // }
                })->with('apprenant', 'apprenant.etablissement', 'cycleFiliere.cycle', 'cycleFiliere.filiere', 'niveau', 'annee')->get();
                // dd($list);
                if($section == '1' || $section == '2'){
                    $findEtabSection = DB::table('etablissement_section')->where('section_id', (int)$section)->first()->id;
    
                    $apprenantsCABySection = ApprenantClasseAnnee::with('apprenant', 'classe_annee.annee', 'classe_annee.classe', 'classe_annee.classe.niveau')
                        ->whereHas('classe_annee', function ($query) use ($year, $matricule,$nom,$prenom,$findEtabSection) {
                            $query->whereHas('classe', function ($query) use ($findEtabSection){
                                $query->where('etablissement_section_id',$findEtabSection);
                            })->whereHas('annee', function ($query) use ($year, $matricule,$nom,$prenom){
                                if($matricule !== null || $nom !== null || $prenom !== null){
                       
                                }else{
                                    $query->where('annee_id',$year);
                                }
                            });
                        })
                        ->whereHas('apprenant', function ($query) use ($matricule,$nom,$prenom,$authUser) {
                            if($matricule !== null){
                                $query->where('matricule','like', '%' . $matricule . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                                // dump('matricule',$matricule);
                            }elseif($nom != null && $prenom != null){
                                $query->where('nom','like', '%' . $nom . '%')->where('prenom','like', '%' . $prenom . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                            }else{
                                $query->where('nom','like', '%' . $nom . '%')->orWhere('prenom','like', '%' . $prenom . '%')->where('etablissement_id', (int)$authUser->etablissement_id);
                            }
                        })
                        ->get();
                        // dd($apprenantsCABySection,$list);
                    $list->map(function ($element) use ($apprenantsCABySection, $collection) {
                        $vTerre = $apprenantsCABySection->filter(function ($el) use ($element) {
                            return $el['apprenant_id'] == $element['apprenant_id'];
                        });
                        return $collection->push($vTerre->filter()->all());
                    });
                }
            }
            if($section == '1' || $section == '2'){
                $flattened = $collection->flatten()->unique()->filter();
                $flattened->all();
                // dd($flattened);
                return $flattened ?? [];
            }elseif($section == '3' || $section == '4'){
                return $list ?? []; 
            }
        
    }

    public function getFrais($niveau,$annee)
    {
        // dd($niveau);
        $frais_scolarite = 0;
        $frais = Frais::where('type_frais_id',2)->where('annee_id',$annee)->where('etablissement_id',Auth::user()->etablissement_id)->where('niveau_id',$niveau)->first();
        if($frais){
            $frais_scolarite = $frais->montant;
        }
        // dd($frais_scolarite);
        return $frais_scolarite;
    }
    
    public function checkClasse($niveau,$etabSection)
    {
        // dd($niveau,$etabSection);
        $donnees = [];
        $tabs = [];
        if($niveau && $etabSection){
            $result = ClasseAnnee::whereHas('classe', function ($query) use ($niveau,$etabSection){
                $query->where('niveau_id',$niveau)->where('etablissement_section_id',$etabSection);
            })->with('classe.niveau')->get();

            if($result->count() > 0){
                foreach($result as $key => $item){
                    $nbre = ApprenantClasseAnnee::where('classe_annee_id',$item->id)->count();
                    $tabs = [
                        'classe' => $item,
                        'nbre' => $nbre
                    ];
                    $donnees[$key] = $tabs;
                }
                // dd($donnees);
                return ['code'=> 1, $donnees ?? []];
            }else{
                return ['code'=> 0];
            }
        }else{
            return 'ERREUR';
        }
    }

    // Fin requete AXIOS

    // DEBUT FUNCTION HELPERS
    public function generateMatricule($donnees)
    {
        // dd($donnees['annees']['etablissement_section_id']['pivot']['etablissement_id']);
        // dd(CycleFiliere::find($donnees['annees']['cycle_filiere'])->with('filiere')->first());
        $mat = "";
        // $s = substr($this->getNameSection($donnees['section']), 0, 1);
        $words = preg_split(
            "/(\s|\-|\.)/",Etablissement::find($donnees['annees']['etablissement_section_id']['pivot']['etablissement_id'])->name
        );
        $n = "";
        $o = 0;
        $f = "";
        foreach ($words as $w) {
            $n .= substr($w, 0, 1);
        }
        $o = Apprenant::where('etablissement_id',$donnees['annees']['etablissement_section_id']['pivot']['etablissement_id'])->count() + 1;


        $mat = 'US-'.$n.'-0'.$o;
        // $a = Annee::find($donnees['annees']['annee'])->libelle;
        // if($donnees['section'] == '1' || $donnees['section'] == '2'){
        //     $o = Inscription::where('annee_id',$donnees['annees']['annee'])->where('niveau_id',$donnees['annees']['niveau'])->count() + 1;
        // }elseif($donnees['section'] == '3' || $donnees['section'] == '4'){
        //     $o = Inscription::where('annee_id',$donnees['annees']['annee'])->where('niveau_id',$donnees['annees']['niveau'])->where('cycle_filiere_id',$donnees['annees']['cycle_filiere'])->count() + 1;
        // }
        // if($donnees['section'] == '1' || $donnees['section'] == '2'){
           
        // }elseif($donnees['section'] == '3' || $donnees['section'] == '4'){
        //     $f = substr(CycleFiliere::find($donnees['annees']['cycle_filiere'])->with('filiere')->first()->filiere->name, 0, 1);
        //     $mat = 'US-'.$s.$a.$n.$f.$o;
        // }
        return $mat ?? "";
    }

    public function generateCodeInscription($donnees)
    {
        // dd($donnees['section']);
        // dd(CycleFiliere::find($donnees['annees']['cycle_filiere'])->with('filiere')->first());
        $mat = "";
        $s = substr($this->getNameSection($donnees['section']), 0, 1);
        $words = preg_split(
            "/(\s|\-|\.)/",Niveau::find($donnees['annees']['niveau'])->libelle
        );
        $n = "";
        $o = 0;
        $f = "";
        foreach ($words as $w) {
            $n .= substr($w, 0, 1);
        }
        $a = Annee::find($donnees['annees']['annee'])->libelle;
        if($donnees['section'] == '1' || $donnees['section'] == '2'){
            $o = Inscription::where('annee_id',$donnees['annees']['annee'])->where('niveau_id',$donnees['annees']['niveau'])->count() + 1;
        }elseif($donnees['section'] == '3' || $donnees['section'] == '4'){
            $o = Inscription::where('annee_id',$donnees['annees']['annee'])->where('niveau_id',$donnees['annees']['niveau'])->where('cycle_filiere_id',$donnees['annees']['cycle_filiere'])->count() + 1;
        }
        if($donnees['section'] == '1' || $donnees['section'] == '2'){
            $mat = 'US-'.$s.'-'.$a.'-'.$n.'-'.$o;
        }elseif($donnees['section'] == '3' || $donnees['section'] == '4'){
            $f = substr(CycleFiliere::find($donnees['annees']['cycle_filiere'])->with('filiere')->first()->filiere->name, 0, 1);
            $mat = 'US-'.'-'.$s.'-'.$a.'-'.$n.'-'.$f.'-'.$o;
        }
        return $mat ?? "";
    }

    public function getNameSection($section)
    {
        $name = '';
        if ($section == '1') {
            $name = 'Primaire';
        }
        if ($section == '2') {
            $name = 'Secondaire';
        }
        if ($section == '3') {
            $name = 'Supérieure';
        }
        if ($section == '4') {
            $name = 'Universitaire';
        }
        return $name;
    }
    // FIN FUNCTION HELPER

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        /////////////////////////////  matricule  ///////////////////////
        $matricule = $this->generateMatricule($request->all());
        $code_inscription = $this->generateCodeInscription($request->all());
        // dd($code_inscription,$matricule);
        $id_apprenant = null;

        // $type_frais = TypeFrais::where('libelle','Frais de scolarité')->first();
        // $frais = Frais::where('type_frais_id',$type_frais->id)->where('annee_id',$request->annees['annee'])->where('niveau_id',$request->annees['niveau'])
        // ->where('etablissement_id',Auth::user()->etablissement_id)->first();
        // // dd($frais);
        // if($frais == null){
        //     return redirect()->back()->with('message', [
        //         'type' => 'error',
        //         'text' => 'frais de scolarité manquants',
        //     ]);
        // }
        if($request->apprenants){
            $find = Apprenant::where('nom',$request->apprenants['nom'])->where('prenom',$request->apprenants['prenom'])->where('sexe',$request->apprenants['sexe'])
            ->where('date_naissance',$request->apprenants['date_naissance'])->where('lieu_naissance',$request->apprenants['lieu_naissance'])->where('telephone',$request->apprenants['telephone'])
            ->where('etablissement_id',Auth::user()->etablissement_id)->first();
            if($find == null){
                $item_apprenant = Apprenant::create([
                    'matricule' => $matricule,
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
            if($request->section == '1' || $request->section == '2'){
                $inscription = Inscription::create([
                    'code' => $code_inscription,
                    'date_inscription' => date('Y-m-d'),
                    'annee_id' => $request->annees['annee'],
                    'niveau_id' => $request->annees['niveau'],
                    'apprenant_id' => $id_apprenant,
                    'statut' => 0
                ]);
            }elseif($request->section == '3' || $request->section == '4'){
                $inscription = Inscription::create([
                    'code' => $code_inscription,
                    'date_inscription' => date('Y-m-d'),
                    'annee_id' => $request->annees['annee'],
                    'niveau_id' => $request->annees['niveau'],
                    'cycle_filiere_id' => $request->annees['cycle_filiere'],
                    'apprenant_id' => $id_apprenant,
                    'statut' => 0
                ]);
            }
        }else{
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'Cette inscription existe déjà',
            ]);
        }

        if($request->section == '1' || $request->section == '2'){
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
        }

        // Versement

        
        // Versement::create([
        //     'inscription_id' => $inscription->id,
        //     'frais_id' => $frais->id,
        //     'montant' => $request->annees['versement'],
        //     'date_versement' => date('Y-m-d')
        // ]);

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
