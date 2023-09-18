<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apprenant;
use Modules\Enseignement\Entities\Enseignant;
use App\Models\PermissionRole;
use App\Models\Permission;
use App\Models\Etablissement;
use App\Models\Role;
use App\Models\Section;
use App\Models\EtablissementSection;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('user/Index', [
           'users'=> User::where('user_id',Auth::user()->id)->get() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return Inertia::render('user/Create', [
            'etablissements'=>Etablissement::all(),
            'roles'=>Role::all(),  
            'sections'=>Section::all(),
            'permissions'=>Permission::all(),
            'enseignants'=>Enseignant::where('etablissement_id',Auth::user()->etablissement_id)->get(),
            'apprenants'=>Apprenant::where('etablissement_id',Auth::user()->etablissement_id)->get(),
            'etablissement_sections'=> Section::whereHas('etablissements.users',function($q) use ($user){
                $q->where('id',$user->id);
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
        $nom = str_replace(' ', '', $request->nom);
        $prenom = str_replace(' ', '', $request->prenom);
        $login  = strtolower($nom).'-'. strtolower($prenom) . '@gmail.com';
        if($request->nom and $request->prenom){
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $login,
            'user_id'=>Auth::user()->id,
            'password' => Hash::make($login),
            'etablissement_id'=>$request->etablissement_id,
            'enseignant_id'=>$request->enseignant_id,
            'apprenant_id'=>$request->apprenant_id
        ]);
        if ($request->section) { 
            $user->etablissement_section_id = EtablissementSection::where('etablissement_id',Auth::user()->etablissement_id)->where('section_id',$request->section)->get()[0]->id;
        }
        foreach($request->roles as $role) {            
            $permissions = PermissionRole::where('role_id',$role)->where('user_id',Auth::user()->id)->get();
        }
        foreach ($permissions as $permission) {
            $permis[] = $permission->permission_id;
        }
        $user->syncPermissions($permis);
        if($request->etablissement_id){
            $etablissement = Etablissement::find($request->etablissement_id);
            $etablissement->sections()->attach($request->sections);
        }
        
        return redirect()->route('users.index')->with('message', 'Utilisateur a été crée avec succès !');
        }
        else {
            return redirect()->back()->with('messages', 'Veuillez réenseigner tous les champs ayant étoille rouge!');

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
    public function edit(string $id)
    {
        //
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