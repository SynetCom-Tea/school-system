<?php

namespace Modules\Enseignement\Http\Controllers;

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
use Modules\Enseignement\Entities\Matiere;

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
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();


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
        // dd($request->matieres);
        $ets_id = Auth::user()->etablissement_id;
        request()->validate([
            'matricule' => 'required|string',
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
        $data['NomComplet']=$nomcomplet;
        $data['date_lieu_nais']=$date_lieu;

        $enseig=Enseignant::create($data);
        foreach($request->matieres as $matiere){
            EnseignantMatiere::create([
                'enseignant_id' => $enseig->id,
                'matiere_id' => $matiere,
            ]);
        }

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

        return redirect()->route('enseignants.index')->with('message', [
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
