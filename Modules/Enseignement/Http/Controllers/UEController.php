<?php

namespace Modules\Enseignement\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Enseignement\Entities\Ue;
use Modules\Enseignement\Entities\Filliere;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Modules\Enseignement\Entities\EtablissementFilliere;

class UEController extends Controller
{
    public function index(Request $request){
       return Inertia::render('UE/index',[
            'ues'=>Ue::all()
        ]);
    }
    // 74320809 94986444
    
    public function create(Request $request){
        $user = Auth::user();
        $filiere = EtablissementFilliere::whereHas('etablissement.users', function ($query) use($user){
            $query->where('id',$user->id);}
        )->with('etablissement','filliere')->get();
        // dd($filiere);
        return Inertia::render('UE/create',[
            'filliere_etablissements'=>$filiere,
        ]);
    }
    public function store(Request $request){
        return redirect()->route('ues.index')->with('message','Unité d\'enseignement crée avec success');
    }
}
