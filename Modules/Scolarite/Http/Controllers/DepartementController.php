<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Modules\Scolarite\Entities\Departement;
use Modules\Scolarite\Entities\Faculte;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ets_id = Auth::user()->etablissement_id;
        $dep = Departement::with('faculte')->whereHas('faculte',function ($query) use ($ets_id){

            $query->where('etablissement_id',$ets_id);})->get();
        return Inertia::render('Departements/Index', [
            'departements' => $dep,
            'facultes' => Faculte::where('etablissement_id',$ets_id)->get(),
        ]);  
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $ets_id = Auth::user()->etablissement_id;
        request()->validate([
            'code' => 'required|string',
            'libelle' => 'required|string',
        ]);
        $data = $request->all();
        
        Departement::create($data);
        return redirect()->route('departements.index', $type)->with('message', [
            'type' => 'success',
            'text' => "Le Département a été créé avec succès !",
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request,string $id)
    {
        $dep = Departement::find($id);
        $dep->update($request->all());
        return redirect()->route('departements.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(string $id)
    {
        try{
            $dep = Departement::find($id);
            $dep->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->route('departements.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer ce Département!",
                ]);

            }
        }
        return redirect()->route('departements.index')->with('message', [
            'type' => 'success',
            'text' => "Le Département a été supprimée avec succès !",
        ]);
    }
}
