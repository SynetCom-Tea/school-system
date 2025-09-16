<?php

namespace App\Http\Controllers;

use App\Models\TypeEtablissement;
use App\Models\Etablissement;
use App\Models\Section;
use App\Models\EtablissementSection;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //  public function getResouces($model){
    //     $data=[];
    //     if($model=='getFourTypeSections'){
    //         $data=EtablissementSection::whereHas('section_id', function($query){
    //             $query->where('drsp_id', '<>', null)->where('statut', 1)->where('etat', 1);
    //         });

    //     }
    //     return $data;
    // }
    public function index()
    {
        // dd(TypeEtablissement::all());
        return Inertia::render('Etablissement/Index', [
            'ecoles' => Etablissement::with('type_etablissement', 'sections', 'users')->where('type_etablissement_id','1')->get(),
            'instituts' => Etablissement::with('type_etablissement', 'sections', 'users')->where('type_etablissement_id','2')->get(),
            'types' => TypeEtablissement::all(),
            'sections' => Section::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd(TypeEtablissement::all());
        return Inertia::render('Etablissement/Create', [
            'types' => TypeEtablissement::all(),
            'sections' => Section::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logo = '';
        $data = [
            'name' => $request->name, 'email' => $request->email, 'adresse' => $request->adresse,
            'telephone' => $request->telephone, 'telephone' => $request->telephone,
            'ville' => $request->ville, 'type_etablissement_id' => $request->type_etablissement_id, 'statut' => 1
        ];
        if ($request->file('logo')) {

            $logo = $request->file('logo')[0]->getClientOriginalName();
            $request->file('logo')[0]->move('logos/', $request->file('logo')[0]->getClientOriginalName());
            $data['logo'] = $logo;
        }
        $ets = Etablissement::create($data);
        if ($request->section) {
            $ets->sections()->attach($request->section);
        } else {
            $ets->sections()->attach(3);
        }

        $user = [
            'user_id'=>1,
            'nom' => $request->nom, 
            'prenom' => $request->prenom, 
            'email' => $request->mail,
            'username' => strtolower($request->nom) . '-' . strtolower($request->prenom),
            'password' => $request->password ?? Hash::make('password'), 
            'etablissement_id' => $ets->id
        ];
        $admin = User::create($user);
        $admin->givePermissionTo('manage_school');
        return redirect()->route('etablissements.index');
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
        $ets = Etablissement::find($id);
        if ($request->type_etablissement_id == 1) {
            $ets->sections()->sync($request->section);
        } else {
            $ets->sections()->sync(3);
        }

        $ets->update($request->all());

        return redirect()->route('etablissements.index');
    }

    /**
     * Active or desactive the specified resource in storage.
     */

    public function activer(Request $request, string $id)
    {
        $ets = Etablissement::find($id);
        if ($ets->statut == 1) {
            $ets->update(['statut' => 0]);
        } else {
            $ets->update(['statut' => 1]);
        }

        return redirect()->route('etablissements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
