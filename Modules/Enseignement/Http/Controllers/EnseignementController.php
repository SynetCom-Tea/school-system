<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Classe;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Matiere;
use App\Models\Etablissement;
use App\Models\Parametre;
use Modules\Scolarite\Entities\TypeFrais;
use App\Models\Salle;
use App\Models\Section;
use App\Models\SystemeLmd;
use App\Models\TypeDocument;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\Filiere;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;
use Modules\Enseignement\Entities\NiveauMatiere;
use Modules\Enseignement\Entities\Ue;
use Modules\Scolarite\Entities\Departement;
use Modules\Scolarite\Entities\EtablissementTypeDocument;
use Modules\Scolarite\Entities\EtablissementTypeFrais;
use Modules\Scolarite\Entities\Faculte;
use Modules\Scolarite\Entities\Frais;

class EnseignementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return Inertia::render('Admin/accueil');
    }




    // ****************************Parametrage de type frais, type document et la limite par classe par etablissement************************************

    public function getPageParam($type){
        $et_sec_id = getSectionEtablissement(Auth::user()->etablissement_id, $type)->first();
        // dd(EtablissementTypeDocument::where('etablissement_section_id',$et_sec_id)->where('statut','1')->with('type_document')->get());
        return Inertia::render('Enseignement/Configs/param_index',[
            'type' => $type,
            'type_documents' => TypeDocument::all(),
            'type_frais' => TypeFrais::all(),
            'liste_document' => EtablissementTypeDocument::where('etablissement_section_id',$et_sec_id)->where('statut','1')->with('type_document')->get(),
            'liste_frais' => EtablissementTypeFrais::where('etablissement_section_id',$et_sec_id)->where('statut',1)->with('type_frais')->get(),
            'nbre' => Parametre::where('etablissement_section_id',$et_sec_id)->first() ? Parametre::where('etablissement_section_id',$et_sec_id)->first()->nbre_limite_eleve_par_classe : null,
        ]);
    }

    public function saveParam(Request $request){
        // dd($request->all());
        $check = 0;
        $elementsNotDeleted = [];
        $et_sec_id = getSectionEtablissement(Auth::user()->etablissement_id, $request->section)->first();

        // ETABLISSEMENT TYPE FRAIS
        $uncheckedFraisElements = EtablissementTypeFrais::whereNotIn('type_frais_id',$request->selected_frais)->where('etablissement_section_id',$et_sec_id)->get();

        foreach ($uncheckedFraisElements as $element) {
            $checkNotUsedInFrais = Frais::where('etablissement_type_frais_id',$element->id)->first();
            if(is_null($checkNotUsedInFrais)){
                $element->delete();
            }else{
                $elementsNotDeleted[] = $element; 
            }
        }

        foreach ($request->selected_frais as $elementId) {
            EtablissementTypeFrais::updateOrCreate(
                [
                    'type_frais_id' => $elementId,
                    'etablissement_section_id' => $et_sec_id
                ],
                [
                    'type_frais_id' => $elementId,
                    'etablissement_section_id' => $et_sec_id,
                    'statut' => 1
                ]
            );
        }


        // ETABLISSEMENT TYPE DOCUMENT


        $uncheckedDocumentsElements = EtablissementTypeDocument::whereNotIn('type_document_id',$request->selected_documents)->where('etablissement_section_id',$et_sec_id)->get();

        foreach ($uncheckedDocumentsElements as $element) {
            $element->delete();
            // $checkNotUsedInFrais = Frais::where('etablissement_type_frais_id',$element->id)->first();
            // if(is_null($checkNotUsedInFrais)){
            //     $element->delete();
            // }else{
            //     $elementsNotDeleted[] = $element; 
            // }
        }

        foreach ($request->selected_documents as $elementId) {
            $obligatoire = in_array($elementId, $request->selected_obligatoires) ? 1 : 0;
            EtablissementTypeDocument::updateOrCreate(
                [
                    'type_document_id' => $elementId,
                    'etablissement_section_id' => $et_sec_id
                ],
                [
                    'type_document_id' => $elementId,
                    'etablissement_section_id' => $et_sec_id,
                    'obligatoire' => $obligatoire,
                    'statut' => 1
                ]
            );
        }

        /////////////////////// fin type document ///////////////////////

        Parametre::updateOrCreate(
            [
                'etablissement_section_id' => $et_sec_id,
            ],
            [
            'etablissement_section_id' => $et_sec_id,
            'nbre_limite_eleve_par_classe' => $request->nbre_limite,
            ]
        );


        ///////////////////// fin nombre limite //////////////////////

        $check = 1;
        if($check == 1){
            return redirect()->route('param.index',$request->section)->with('message', [
                'type' => 'success',
                'text' => "Enregistrement effectué avec succes !",
            ]);
        }else{
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => "Un probleme est survenu lors de l'enregistrement !",
            ]);
        }

    }


    // ********************************************************************************

    public function config($type)
    {
        $table = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $type)->first();
        $id = $table->id;
        $lmd = $table->systeme_lmd_id;

        return Inertia::render('Admin/config', [
            'type' => $type,
            'niveaux' => Niveau::where('section_id', $type)->get(),
            'typeFrais' => TypeFrais::all(),
            // 'matieres' => Matiere::where('etablissement_id', Auth::user()->etablissement_id)->get(),
            'lmd' => $lmd
        ]);
    }

    //Pour la gestion des cruds après la configuration
    public function gestion($type)
    {
        // dd(Auth::user());
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id', $ets_id)->where('section_id', $type)->first();
        $etab_sec_id = $table->id;

        $nbre_matieres = Matiere::where('etablissement_section_id',$etab_sec_id)->count();
        $nbre_salles = Salle::where('etablissement_id', $ets_id)->count();
        $nbre_classes = Classe::where('etablissement_section_id',$etab_sec_id)->count();
        $nbre_type_frais = EtablissementTypeFrais::where('etablissement_section_id',$etab_sec_id)->count();
        $nbre_enseignant = Enseignant::where('etablissement_id', $ets_id)->count();
        if($type<=2){
            $nbre_niveau_matiere = NiveauMatiere::whereHas('matiere', function($query) use ($etab_sec_id){
                $query->where('etablissement_section_id',$etab_sec_id);
            })->count();
        }else{
            $nbre_niveau_matiere = FiliereNiveauMatiereUe::whereHas('matiere', function($query) use ($etab_sec_id){
                $query->where('etablissement_section_id',$etab_sec_id);
            })->count();
        }


        $nbre_cycle_filiere = CycleFiliere::whereHas('filiere', function($query) use ($etab_sec_id){
            $query->where('etablissement_section_id',$etab_sec_id);
        })->count();
        // dd('salle',$nbre_salles,'matiere',$nbre_matieres,'classe',$nbre_classes,'type frais',$nbre_type_frais,'niveau matiere',$nbre_niveau_matiere,'enseignant',$nbre_enseignant);

        return Inertia::render('Admin/postConfig', [
            'type' => $type,
            'niveaux' => Niveau::where('section_id', $type)->get(),
            'nbre_matieres' => $nbre_matieres,
            'nbre_salles' => $nbre_salles,
            'nbre_classes' => $nbre_classes,
            'nbre_type_frais' => $nbre_type_frais,
            'nbre_enseignant' => $nbre_enseignant,
            'nbre_niveau_matiere' => $nbre_niveau_matiere,
            'nbre_cycle_filiere' =>$nbre_cycle_filiere,
            'systemeLMD'=>$table->systeme_lmd_id,
        ]);
    }

    public function lmd($type)
    {
        return Inertia::render('Admin/lmd', [
            'type' => $type,
            'lmds' => SystemeLmd::all()
        ]);
    }

    public function storelmd(Request $request)
    {
        // dd($request->type_lmd);
        $eva = null;
        $ligne = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->first();
        // dd($ligne);
        if ($ligne) {
            if ($request->regime_evaluation == true) {
                $eva = 1;
            } else {
                $eva = 0;
            }
            if ($request->lmd) {
                DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->update([
                    'systeme_lmd_id' => $request->type_lmd,
                    'regime_evaluation' => $eva
                ]);
            } else {
                DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->update([
                    'systeme_lmd_id' => null,
                    'regime_evaluation' => $eva
                ]);
            }
        }
        return redirect()->route('admin.config', $request->type);
    }

    public function storeConfig(Request $request)
    {
        $etablissement_section = $request->section;
        if ($request->section == 1 || $request->section == 2) {
            // dd($request);
            foreach ($request->matieres['matieres'] as $matieres) {
                $matiere = ['code' => $matieres['code'], 'nom' => $matieres['libelle'], 'etablissement_section_id' => $etablissement_section];
                // dd($matiere);
                Matiere::create($matiere);
            }

            foreach ($request->classes['classes'] as $classes) {
                $classe = ['code' => $classes['code'], 'libelle' => $classes['libelle'], 'etablissement_section_id' => $etablissement_section, 'niveau_id' => $classes['niveau']];
                // dd($classe);
                Classe::create($classe);
            }

            foreach ($request->frais['frais'] as $frais) {
                $frai = ['type_frais_id' => $frais['type_frais'], 'annee_id' => 1, 'montant' => $frais['montant'], 'etablissement_id' => Auth::user()->etablissement_id, 'niveau_id' => $frais['niveau']];
                //  dd($frai);
                Frais::create($frai);
            }
        } else if ($request->section == 3 && $request->systemeLMD != null) {
            // dd($request);
            foreach ($request->matieres['matieres'] as $matieres) {
                $matiere = ['code' => $matieres['code'], 'nom' => $matieres['libelle'], 'etablissement_section_id' => $etablissement_section];
                // dd($matiere);
                Matiere::create($matiere);
            }

            foreach ($request->classes['classes'] as $classes) {
                $classe = ['code' => $classes['code'], 'libelle' => $classes['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                Salle::create($classe);
            }
            foreach ($request->Ue['ues'] as $ues) {
                $ue = ['code' => $ues['code'], 'libelle' => $ues['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                Ue::create($ue);
            }

            foreach ($request->filieres['filieres'] as $filieres) {
                $filiere = ['code' => $filieres['code'], 'name' => $filieres['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                $nfiliere = Filiere::create($filiere);

                foreach ($request->frais['frais'] as $frais) {

                    if ($nfiliere->code == $frais['filiere']) {
                        $frai = ['type_frais_id' => $frais['type_frais'], 'annee_id' => 1,'filiere_id' => $nfiliere->id, 'montant' => $frais['montant'], 'etablissement_id' => Auth::user()->etablissement_id, 'niveau_id' => $frais['niveau']];
                        // dd($frai);
                        Frais::create($frai);
                    }
                }
            }
        } else if ($request->section == 3 && $request->systemeLMD == null) {
            // dd($request);
            foreach ($request->matieres['matieres'] as $matieres) {
                $matiere = ['code' => $matieres['code'], 'nom' => $matieres['libelle'], 'etablissement_section_id' => $etablissement_section];
                // dd($matiere);
                Matiere::create($matiere);
            }

            foreach ($request->classes['classes'] as $classes) {
                $classe = ['code' => $classes['code'], 'libelle' => $classes['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                Salle::create($classe);
            }

            foreach ($request->filieres['filieres'] as $filieres) {
                $filiere = ['code' => $filieres['code'], 'name' => $filieres['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                $nfiliere = Filiere::create($filiere);

                foreach ($request->frais['frais'] as $frais) {

                    if ($nfiliere->code == $frais['filiere']) {
                        $frai = ['type_frais_id' => $frais['type_frais'], 'annee_id' => 1, 'filiere_id' => $nfiliere->id, 'montant' => $frais['montant'], 'etablissement_id' => Auth::user()->etablissement_id, 'niveau_id' => $frais['niveau']];
                        // dd($frai);
                        Frais::create($frai);
                    }
                }
            }
        } else if ($request->section == 4 && $request->systemeLMD != null) {
            // dd($request);
            foreach ($request->matieres['matieres'] as $matieres) {
                $matiere = ['code' => $matieres['code'], 'nom' => $matieres['libelle'], 'etablissement_section_id' => $etablissement_section];
                // dd($matiere);
                Matiere::create($matiere);
            }

            foreach ($request->classes['classes'] as $classes) {
                $classe = ['code' => $classes['code'], 'libelle' => $classes['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                Salle::create($classe);
            }
            foreach ($request->Ue['ues'] as $ues) {
                $ue = ['code' => $ues['code'], 'libelle' => $ues['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                Ue::create($ue);
            }
            foreach ($request->facultes['facultes'] as $facultes) {
                $faculte = ['code' => $facultes['code'], 'libelle' => $facultes['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                $nfaculte = Faculte::create($faculte);
                if ($nfaculte->code == $request->filieres['faculte']) {
                    foreach ($request->filieres['departements'] as $departements) {
                        $departement = ['libelle' =>  $departements['departement'], 'faculte_id' => $nfaculte->id,];
                        // dd($departement);
                        $ndepartement = Departement::create($departement);
                        foreach ($departements['filieres'] as $filieres) {
                            $filiere = ['code' => $filieres['code'], 'name' => $filieres['libelle'], 'departement_id' =>  $ndepartement->id,];
                            // dd($classe);
                            $nfiliere = Filiere::create($filiere);

                            foreach ($request->frais['frais'] as $frais) {

                                if ($nfiliere->code == $frais['filiere']) {
                                    $frai = ['type_frais_id' => $frais['type_frais'], 'annee_id' => 1, 'filiere_id' => $nfiliere->id, 'montant' => $frais['montant'], 'etablissement_id' => Auth::user()->etablissement_id, 'niveau_id' => $frais['niveau']];
                                    // dd($frai);
                                    Frais::create($frai);
                                }
                            }
                        }
                    }
                    # code...
                }
            }
        } else if ($request->section == 4 && $request->systemeLMD == null) {
            // dd($request);
            foreach ($request->matieres['matieres'] as $matieres) {
                $matiere = ['code' => $matieres['code'], 'nom' => $matieres['libelle'], 'etablissement_section_id' => $etablissement_section];
                // dd($matiere);
                Matiere::create($matiere);
            }

            foreach ($request->classes['classes'] as $classes) {
                $classe = ['code' => $classes['code'], 'libelle' => $classes['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                Salle::create($classe);
            }
            foreach ($request->facultes['facultes'] as $facultes) {
                $faculte = ['code' => $facultes['code'], 'libelle' => $facultes['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
                // dd($classe);
                $nfaculte = Faculte::create($faculte);
                if ($nfaculte->code == $request->filieres['faculte']) {
                    foreach ($request->filieres['departements'] as $departements) {
                        $departement = ['libelle' =>  $departements['departement'], 'faculte_id' => $nfaculte->id,];
                        // dd($departement);
                        $ndepartement = Departement::create($departement);
                        foreach ($departements['filieres'] as $filieres) {
                            $filiere = ['code' => $filieres['code'], 'name' => $filieres['libelle'], 'departement_id' =>  $ndepartement->id,];
                            // dd($classe);
                            $nfiliere = Filiere::create($filiere);

                            foreach ($request->frais['frais'] as $frais) {

                                if ($nfiliere->code == $frais['filiere']) {
                                    $frai = ['type_frais_id' => $frais['type_frais'], 'annee_id' => 1, 'filiere_id' => $nfiliere->id, 'montant' => $frais['montant'], 'etablissement_id' => Auth::user()->etablissement_id, 'niveau_id' => $frais['niveau']];
                                    // dd($frai);
                                    Frais::create($frai);
                                }
                            }
                        }
                    }
                    # code...
                }
            }
        }
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Effectuer avec succes',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('enseignement::create');
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
        return view('enseignement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('enseignement::edit');
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
