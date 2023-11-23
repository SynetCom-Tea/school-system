<?php

namespace Modules\Scolarite\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Inertia\Inertia;


use Modules\Scolarite\Entities\Inscription;
use Modules\Scolarite\Entities\Versement;
use Modules\Scolarite\Entities\Frais;
use Modules\Scolarite\Entities\TypeFrais;
use App\Models\User;
use Modules\Scolarite\Entities\EtablissementTypeFrais;

class VersementController extends Controller
{

    // FUNCTION AJAX
    public function ajaxGetInscriptionAboutMle(Request $request)
    {
        // dd($request->all());
        $recherche = $request->search;
        $section = $request->section;

        if($recherche && $section){
            $items = $recherche ? Inscription::whereHas('apprenant', function($query) use ($recherche){
                $query->where('etablissement_id',Auth::user()->etablissement_id)->where('matricule','like', '%' . $recherche . '%')->orWhere('nom','like', '%' . $recherche . '%')->orWhere('prenom','like', '%' . $recherche . '%');
            })->whereHas('niveau', function($query) use ($section){
                $query->where('section_id',$section);
            })->with('apprenant','annee','niveau')->get() : [];

            // dd($items);
            return $items;
        }else{
            return 'ERREUR';
        }
    }

    public function ajaxGetInscriptionForVersement(Request $request)
    {
        // dd($request->all());
        $code = $request->code;
        $section = $request->section;

        $item = $code ? Inscription::where('code',$code)->whereHas('niveau', function($query) use ($section){
            $query->where('section_id',(int)$section);
        })->with('apprenant','cycleFiliere','annee','niveau','versements.frais.etablissement_type_frais.type_frais')->get() : [];
        // dd($item);
        return $item;
    }

    public function calculFrais(Request $request)
    {
    //  dd($request->all());

        if($request->inscription){
            $inscription = Inscription::find($request->inscription);
            $etab_type_frais = !isset($request->tous_frais) ? EtablissementTypeFrais::where('type_frais_id',$request->type_frais)->where('statut',1)->where('etablissement_section_id',getSectionEtablissement(Auth::user()->etablissement_id, $request->section))->first() : null;
            $frais = !is_null($etab_type_frais) ? Frais::where('etablissement_type_frais_id',$etab_type_frais->id)->where('annee_id',$inscription->annee_id)->where('niveau_id',$inscription->niveau_id)->
            where(function($query) use ($inscription){
                if($inscription->cycle_filiere_id == null){

                }else{
                    $query->where('cycle_filiere_id',$inscription->cycle_filiere_id);
                }
           })->first() :
            Frais::whereHas('etablissement_type_frais', function($query) use ($request){
                $query->where('etablissement_section_id',getSectionEtablissement(Auth::user()->etablissement_id, $request->section));
            })->where('annee_id',$inscription->annee_id)->where('niveau_id',$inscription->niveau_id)->where(function($query) use ($inscription){
                if($inscription->cycle_filiere_id == null){

                }else{
                    $query->where('cycle_filiere_id',$inscription->cycle_filiere_id);
                }
           })->sum('montant');
            if(!is_null($frais)){
                $montant_frais = isset($frais->id) ? $frais->montant : $frais;
                $somme_versee = Versement::where('inscription_id',$inscription->id)->where(function ($query) use ($frais) {
                    if(isset($frais->id)){
                        return $query->where('frais_id',$frais->id);
                    } else {

                    }
                })->sum('montant');
                // dd($inscription,$type_frais,$frais,$somme_versee);
                $result = [
                    'somme_versee' => $somme_versee,
                    'total' => $montant_frais
                ];
                // dd($result);
                return ['code'=> 1, 'list'=> $result ?? []];
            }else{
                return ['code'=> 0];
            }
        }else{
            return 'ERREUR';
        }
    }

    public function saveVersement(Request $request)
    {
        // dd($request->all());
        if($request->inscription){
            $inscription = Inscription::find($request->inscription);
            if(!isset($request->tous_frais) || $request->tous_frais == '0'){
                $etab_type_frais = EtablissementTypeFrais::where('etablissement_section_id',getSectionEtablissement(Auth::user()->etablissement_id, $request->section))->where('statut',1)->where('type_frais_id',$request->type_frais)->first();
                $frais = Frais::where('etablissement_type_frais_id',$etab_type_frais->id)->where('annee_id',$inscription->annee_id)->where('niveau_id',$inscription->niveau_id)->
                where(function($query) use ($inscription){
                    if($inscription->cycle_filiere_id == null){

                    }else{
                        $query->where('cycle_filiere_id',$inscription->cycle_filiere_id);
                    }
               })->first();

            }else{
                $etab_type_frais = EtablissementTypeFrais::where('etablissement_section_id',getSectionEtablissement(Auth::user()->etablissement_id, $request->section))->where('statut',1)->with('type_frais')->get();
                $frais = null;
            }
            // dd($etab_type_frais);
            //dd($etab_type_frais,$frais);
            if(!is_null($frais)){
                $versement = Versement::create([
                    'inscription_id' => $inscription->id,
                    'frais_id' => $frais->id,
                    'montant' => (float)$request->montant,
                    'date_versement' => date('Y-m-d'),
                ]);
            }else{
                // dd($etab_type_frais);
                foreach ($etab_type_frais as $key => $value) {
                    # code...
                    // dump($value);
                    $f = Frais::where('etablissement_type_frais_id',$value->id)->where('annee_id',$inscription->annee_id)->where('niveau_id',$inscription->niveau_id)->
                    where(function($query) use ($inscription){
                        if($inscription->cycle_filiere_id == null){

                        }else{
                            $query->where('cycle_filiere_id',$inscription->cycle_filiere_id);
                        }
                   })->first();

                    //  dd($inscription->id,$value);
                    if(!is_null($f)){
                        $v = Versement::where('frais_id',$f->id)->where('inscription_id',$inscription->id)->get();
                        // dd($v);
                        if($v->count() > 0){
                            $sv = Versement::where('frais_id',$f->id)->where('inscription_id',$inscription->id)->sum('montant');
                            // dump($etab_type_frais,$f->montant,$sv);
                            if((float)$f->montant > (float)$sv){
                                $dfm = (float)$f->montant - (float)$sv;
                                Versement::create([
                                    'inscription_id' => $inscription->id,
                                    'frais_id' => $f->id,
                                    'montant' => (float)$dfm,
                                    'date_versement' => date('Y-m-d'),
                                ]);
                            }
                        }else{
                            Versement::create([
                                'inscription_id' => $inscription->id,
                                'frais_id' => $f->id,
                                'montant' => (float)$f->montant,
                                'date_versement' => date('Y-m-d'),
                            ]);
                        }
                    }
                }
                // die();
            }

            $inscription->update(['statut'=>1]);
            $list = Inscription::where('code',$inscription->code)->whereHas('niveau', function($query) use ($request){
                $query->where('section_id',(int)$request->section);
            })->with('apprenant','cycleFiliere','annee','niveau','versements.frais.etablissement_type_frais.type_frais')->get();

            return ['code'=> 1 ,'list' => $list ?? []];
        }else{
            return 'ERREUR';
        }
    }

    public function recuVersement(Request $request){
        $versement = Versement::find($request->id)->with('inscription.annee','inscription.apprenant','inscription.niveau','frais')->first();
        $somme_verse = Versement::where('inscription_id',$versement->inscription_id)->where('frais_id',$versement->frais_id)->sum('montant');
        // dd($versement);
        $etb = Etablissement::find(Auth::user()->etablissement_id);
        $users = User::all();

        $data = [
            'etablissement' => $etb,
            'somme_verse' => $somme_verse,
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'versement' => $versement
        ];

        $pdf = PDF::loadView('recu_versement', $data);

        return $pdf->stream('itsolutionstuff.pdf');
    }

    public function supVersement(Request $request)
    {
        // dd($request->all());
        if($request->id){

            $versement = Versement::find($request->id);
            $versement->delete();

            $list = Inscription::where('code',$versement->inscription->code)->whereHas('niveau', function($query) use ($request){
                $query->where('section_id',(int)$request->section);
            })->with('apprenant','cycleFiliere','annee','niveau','versements.frais.type_frais')->get();

            return ['code'=> 1 ,'list' => $list ?? []];
        }else{
            return 'ERREUR';
        }
    }


    // FIN FUNCTION AJAX


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $type_frais = Frais::whereHas('etablissement_type_frais',function($query) use ($request){
            $query->where('etablissement_section_id',getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id))->where('statut',1);
        })->groupBy('etablissement_type_frais_id')->with('etablissement_type_frais.type_frais')->get();

        // dd($type_frais);
        // $type_frais = EtablissementTypeFrais::where('etablissement_section_id',getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id))->where('statut',1)->with('type_frais')->get();
        // dd($result);
        return Inertia::render('versement/index',[
            'section' => $request->section_id,
            'type_frais' => $type_frais,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

        return Inertia::render('versement/create');
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
