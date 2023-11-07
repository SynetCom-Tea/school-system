<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Annee;
use App\Models\ClasseAnnee;
use App\Models\EtablissementSection;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\EnseignantMatiere;
use Modules\Enseignement\Entities\EnseignementAnnee;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\NiveauMatiere;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class EnseignantController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index($type)
    {
        // dd('salut');
        $ets_id = Auth::user()->etablissement_id;
        // $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();


        $enseignants=Enseignant::where('etablissement_id', $ets_id)->get();
        // View::share('type',$type);
        // dd($enseignants[0]['matricule']);
        $matiere=[];
        $etablissement_section_id= DB::table('etablissement_section')->where('etablissement_id', $ets_id)->get();
        foreach($etablissement_section_id as $etablissement_section){
            $matiere[]=Matiere::where('etablissement_section_id' ,$etablissement_section->id)->get();
        }
        // dd($matiere);
        return Inertia::render('Enseignants/Index', [
            'enseignants' => $enseignants,
            'matieres'=>$matiere,
            'section_id'=>$type,

        ]);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request,$type)
    {
        $ets_id = Auth::user()->etablissement_id;
        $annee = Annee::where('actif',1)->first();
        $enseignement_annee=EnseignementAnnee::all();
        // $matiere=[];
        $classe_annees=[];
        $niveaumatieres=[];
        $etablissement_section_id= DB::table('etablissement_section')->where('etablissement_id', $ets_id)->get();
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();

        $mat = $request->matiere ? Matiere::where('id',$request->matiere)->first():null;
        $classe_annee = $request->classes ? ClasseAnnee::with('classe')->where('id',$request->classes)->first():null;
        $classes_annees = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($table){
            $classe->where('etablissement_section_id',$table->id);
        })->where('annee_id',$annee->id)->get();
        if($classe_annee!=null){

            $niveaumat=NiveauMatiere::with('matiere')->where('niveau_id',$classe_annee->classe->niveau_id)->get();
            foreach($niveaumat as $Niveau_matiere){
                $trouver=false;
                    if($classe_annee->classe->niveau_id== $Niveau_matiere->niveau_id){

                        foreach($enseignement_annee as $enseignement_anne){
                            if($enseignement_anne->classe_annee_id==$classe_annee->id &&  $enseignement_anne->niveau_matiere_id== $Niveau_matiere->id ){
                                    $trouver=true;
                            }
                        }
                        if($trouver==false){
                            $niveaumatieres[]=$Niveau_matiere;
                        }
                    }


            }
        }

        if($mat!=null){


            $classes = ClasseAnnee::with('classe')->whereHas('classe',function($classe) use ($mat){
                $classe->where('etablissement_section_id',$mat->etablissement_section_id);
            })->whereHas('annee',function($anne) use ($annee){
                $anne->where('annee_id',$annee->id);
            })->get();

            foreach($classes as $classe){
                $trouver=false;
                $Niveau_matieres=NiveauMatiere::where('matiere_id',$mat->id)->get();
                foreach($Niveau_matieres as $Niveau_matiere){

                    if( $classe->classe->niveau_id== $Niveau_matiere->niveau_id){
                        // dd($classe->classe->niveau_id);
                        foreach($enseignement_annee as $enseignement_anne){
                            if($enseignement_anne->classe_annee_id==$classe->id &&  $enseignement_anne->niveau_matiere_id== $Niveau_matiere->id ){
                                    $trouver=true;

                            }
                        }
                        if($trouver==false){
                            $classe_annees[]=$classe;
                        }
                    }


                }


            }
            // dd('IF',$classe_annees, $classes);

        }


            $allmatiere=Matiere::where('etablissement_section_id',$table->id)->get();
            $matiere[]= $allmatiere;
           

        // dd($classe_annees);
        return Inertia::render('Enseignants/Create', [
            'matieres'=>$matiere,
            'classes'=>$classe_annees,
            'classe_annees'=>$classes_annees,
            'section_id'=>$type,
            'niveau_matieres'=>$niveaumatieres
        ]);

        // return view('enseignement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$type)
    {
        // dd($request);
        $dernierenseig = Enseignant::latest()->first();
        if($dernierenseig){
            $id_enseig = $dernierenseig->id+1;
        }else{
            $id_enseig = 1;
        }


        $ets_id = Auth::user()->etablissement_id;
        request()->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'sex' => 'required|string',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required|string',
            'telephone' => 'required|string',
        ]);
        $data = $request->all();
        $data['etablissement_id'] = $ets_id;
        $nomcomplet=$data['nom'].' '.$data['prenom'];
        $date_lieu= $data['date_naissance'].' à '.$data['lieu_naissance'];

        $mat='MAT/'.$ets_id.$id_enseig.'E';
        $data['NomComplet']=$nomcomplet;
        $data['date_lieu_nais']=$date_lieu;
        $data['matricule']=$mat;
        $enseig=Enseignant::create($data);
       if($request->importation==true){
        foreach($request->classes as $classe){
            // EnseignantMatiere::create([
            //     'enseignant_id' => $enseig->id,
            //     'matiere_id' => $matiere['matiere'],
            // ]);


            // dd($Niveau_matieres);
            foreach($classe['matieres'] as $matiere){

                // $classe_annee=ClasseAnnee::with('classe')->where('id',$classe)->first();
                // $Niveau_matiere=NiveauMatiere::where('matiere_id',$matiere['matiere'])->where('niveau_id',$classe_annee->classe->niveau_id)->first();


                        EnseignementAnnee::updateOrInsert([
                            'niveau_matiere_id' =>$matiere,
                            'classe_annee_id' => $classe['classe'],
                            'enseignant_id' => $enseig->id,

                        ],
                        [
                            'created_at' => now(), // Remplissez le champ created_at
                            'updated_at' => now() // Remplissez le champ updated_at
                        ]
                        );

                // dd($classe);
            }
        }

        }else{
        foreach($request->matieres as $matiere){
            // EnseignantMatiere::create([
            //     'enseignant_id' => $enseig->id,
            //     'matiere_id' => $matiere['matiere'],
            // ]);


            // dd($Niveau_matieres);
            foreach($matiere['classes'] as $classe){

                $classe_annee=ClasseAnnee::with('classe')->where('id',$classe)->first();
                $Niveau_matiere=NiveauMatiere::where('matiere_id',$matiere['matiere'])->where('niveau_id',$classe_annee->classe->niveau_id)->first();


                        EnseignementAnnee::updateOrInsert([
                            'niveau_matiere_id' => $Niveau_matiere->id,
                            'classe_annee_id' => $classe_annee->id,
                            'enseignant_id' => $enseig->id,

                        ],
                        [
                            'created_at' => now(), // Remplissez le champ created_at
                            'updated_at' => now() // Remplissez le champ updated_at
                        ]
                        );

                // dd($classe);
            }
        }}

        if ($data['compte']==true) {
            $user=['email'=>$request['email'],'password' => Hash::make('password') ,'nom'=>$data['nom'],'prenom'=>$data['prenom'],'etablissement_id'=>$data['etablissement_id'],'user_id '=>Auth::user()->id,'enseignant_id'=>$enseig['id']];
            // dd($user);
            $users=User::create($user);
            $roles=Role::where('name', 'Enseignant')->get()->first();
            $permissions = PermissionRole::where('role_id', $roles['id'])->where('user_id', Auth::user()->id)->get();
            foreach ($permissions as $permission) {
                $permis[] = $permission->permission_id;
            }
            $users->syncRoles($roles);
            $users->syncPermissions($permis);
        }


        return redirect()->route('enseignants.index',$type)->with('message', [
            'type' => 'success',
            'text' => "L'enseignant a été créé avec succès !",
        ]);

        // dd($request);
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
        $enseignants = Enseignant::find($id);
        $enseignants->update($request->all());
        return redirect()->back();
        // dd($id);
        //
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try{
            $enseignants = Enseignant::find($id);
            $enseignants->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cet enseignant!",
                ]);

            }
        }
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => "L'enseignant a été supprimé avec succès !",
        ]);
        //
    }
}
