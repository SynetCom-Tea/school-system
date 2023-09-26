<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apprenant;
use App\Models\ClasseAnnee;
use App\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Section;
use App\Models\Permission;
use App\Models\SectionUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\DB;
use App\Models\EtablissementSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Enseignement\Entities\Niveau;
use Modules\Scolarite\Entities\Inscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Modules\Enseignement\Entities\Enseignant;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getUsersByCategory($params)
    {
        $data = null;
        $list = [];
        $authUser =  Auth::user();
        $nameRole = $authUser->roles[0] ? $authUser->roles[0]->name : null;
        if (Auth::user() == null || Auth::user()->type_user == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        if ($nameRole == 'Administrateur') {
            if ($params == "primaireClasses") {

                $list = Niveau::where('section_id', 1)->get();
            }
            if ($params == "secondaireClasses") {

                $list = Niveau::where('section_id', 2)->get();
            }
            if ($params == "organizationStudents") {

                $list = Inscription::whereHas('apprenant', function ($query) use ($authUser) {
                    $query->where('etablissement_id', (int)$authUser->etablissement_id);
                })->with('apprenant', 'apprenant.etablissement')->get();
            }
        }
        $terre = ClasseAnnee::with('annee', 'classe', 'classe.niveau')->get();
        // dump('T:', EtablissementSection::all());
        // dump('Test:', $terre);

        return $list ?? [];
    }
    public function index(Request $request)
    {
        if (Auth::user() == null || Auth::user()->type_user == null) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Session expiré!',
            ]);
        }
        return Inertia::render('User/Index', [
            'users' => User::where('user_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return Inertia::render('User/Create', [
            'etablissements' => Etablissement::all(),
            'roles' => Role::all(),
            'sections' => Section::all(),
            'permissions' => Permission::all(),
            'enseignants' => Enseignant::where('etablissement_id', Auth::user()->etablissement_id)->get(),
            'apprenants' => Apprenant::where('etablissement_id', Auth::user()->etablissement_id)->get(),
            'etablissement_sections' => Section::whereHas('etablissements.users', function ($q) use ($user) {
                $q->where('id', $user->id);
            })->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $user = Auth::user();
        $permis = [];  
        $etat = null;
        $nom = str_replace(' ', '', $request->nom);
        $prenom = str_replace(' ', '', $request->prenom);
        $login  = strtolower($nom).'-'. strtolower($prenom) . '@gmail.com';
        if($request->etablissement_id){
            $etat = $request->etablissement_id;
        }else {
            $etat = Auth::user()->etablissement_id;
        }
        if($request->nom and $request->prenom){
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $login,
            'user_id'=>Auth::user()->id,
            'password' => Hash::make($login),
            'etablissement_id'=>$etat,
            'enseignant_id'=>$request->enseignant_id,
            'apprenant_id'=>$request->apprenant_id
        ]);        
        $permissions = PermissionRole::where('role_id',$request->roles)->where('user_id',Auth::user()->id)->get();
        foreach ($permissions as $permission) {
            $permis[] = $permission->permission_id;
        }
        $user->syncRoles($request->roles);
        $user->syncPermissions($permis);

        foreach ($request->section as $sec) {
            $etablissement_sections  = DB::table('etablissement_section')->where('section_id',$sec)->where('etablissement_id',Auth::user()->etablissement_id)->get()[0]; 
            
            SectionUser::create([
                'user_id'=>$user->id,
                'etablissement_section_id'=>$etablissement_sections->id
            ]);
        }
        if($request->etablissement_id){
            $etablissement = Etablissement::find($request->etablissement_id);
            $etablissement->sections()->attach($request->sections);
        }
        
        return redirect()->route('users.index')->with('message', 'Utilisateur a été crée avec succès !');
        }
        else {
            return redirect()->back()->with('messages', 'Veuillez réenseigner tous les champs ayant étoille rouge!');

            return redirect()->route('users.index')->with('message', 'Utilisateur a été crée avec succès !');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function NotFoud(Request $request)
    {
        return Inertia::render('Page');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
