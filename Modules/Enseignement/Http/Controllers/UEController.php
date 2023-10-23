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
    public function index($type){
       return Inertia::render('UE/Index',[
            'ues'=>Ue::all(),
            'section_id'=>$type,
        ]);
    }
    // 74320809 94986444

    public function create(Request $request,$type){
        $user = Auth::user();
        // $filiere = EtablissementFilliere::whereHas('etablissement.users', function ($query) use($user){
        //     $query->where('id',$user->id);}
        // )->with('etablissement','filliere')->get();
        // dd($filiere);
        return Inertia::render('UE/Create',[
            // 'filliere_etablissements'=>$filiere,
            'section_id'=>$type,
        ]);
    }
    public function store(Request $request, $type){

        foreach ($request->ues as $ue) {
            $ue = ['code' => $ue['code'], 'libelle' => $ue['libelle'], 'etablissement_id' => Auth::user()->etablissement_id,];
            // dd($classe);
            Ue::create($ue);
        }
        return redirect()->route('ues.index',$type)->with('message','Unité d\'enseignement crée avec success');
    }
   /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        dd($id);
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
        $ue = Ue::find($id);
        $ue->update($request->all());
        return redirect()->back();
        //
    }

     /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try{
            $ue = Ue::find($id);
            $ue->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette filière!",
                ]);

            }
        }
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => "La filière a été supprimé avec succès !",
        ]);
        //
    }
        //

}
