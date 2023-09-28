<?php

namespace Modules\Scolarite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Modules\Scolarite\Entities\Faculte;

class FaculteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $ets_id = Auth::user()->etablissement_id;
        return Inertia::render('Facultes/Index', [
            'facultes' => Faculte::where('etablissement_id',$ets_id)->get(),
        ]);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ets_id = Auth::user()->etablissement_id;
        request()->validate([
            'code' => 'required|string',
            'libelle' => 'required|string',
        ]);
        $data = $request->all();
        $data['etablissement_id'] = $ets_id;
        Faculte::create($data);
        return redirect()->route('facultes.index')->with('message', [
            'type' => 'success',
            'text' => "La Faculté a été créée avec succès !",
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fac = Faculte::find($id);
        $fac->update($request->all());
        return redirect()->route('facultes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $fac = Faculte::find($id);
            $fac->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            if($e->getCode() == "23000"){
                return redirect()->route('facultes.index')->with('message', [
                    'type' => 'error',
                    'text' => "Désolé, vous ne pouvez pas supprimer cette Faculté!",
                ]);

            }
        }
        return redirect()->route('facultes.index')->with('message', [
            'type' => 'success',
            'text' => "La Faculté a été supprimée avec succès !",
        ]);
    }
}
