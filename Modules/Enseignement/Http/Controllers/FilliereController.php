<?php

namespace Modules\Enseignement\Http\Controllers;

use Inertia\Inertia;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Enseignement\Entities\CycleFiliere;
use Modules\Enseignement\Entities\Filiere;

class FilliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $table = DB::table('etablissement_section')->where('etablissement_id',Auth::user()->etablissement_id)->where('section_id',$type)->first();
        // dd(Filiere::where('etablissement_id',Auth::user()->etablissement_id)->with('cycle_filieres.cycle')->get());
        return Inertia::render('Filliere/Index', [
            'filieres' => Filiere::where('etablissement_section_id',$table->id)->with('cycle_filieres.cycle')->get(),
            'cycles'=>Cycle::all(),
            'section_id' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        //
        $table = DB::table('etablissement_section')->where('etablissement_id',Auth::user()->etablissement_id)->where('section_id',$type)->first();
        return Inertia::render('Filliere/Create', [
            'section_id' =>$type,
            // 'filieres' => Filiere::where('etablissement_id',Auth::user()->etablissement_id)->with('cycle_filieres.cycle')->get(),
            'cycles'=>Cycle::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {

        $table = DB::table('etablissement_section')->where('etablissement_id',Auth::user()->etablissement_id)->where('section_id',$type)->first();
        foreach($request->donnees as $filieres){
            // dd($table->id);
            $filiere=Filiere::create([
                'name' => $filieres['name'],
                'code' => $filieres['code'],
                'etablissement_section_id'=> $table->id,
            ]);
            foreach($filieres['cycles'] as $cyle){
                CycleFiliere::create([
                    'cycle_id'=>$cyle,
                    'filiere_id'=>$filiere->id,
                ]);
            }
        }

        return redirect()->route('filieres.index',$type)->with('message', [
            'type' => 'success',
            'text' => 'Filière créé avec succès!',
        ]);
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
    public function update(Request $request,$id)
    {
        $filiere = Filiere::find($id);
        $filiere->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $filiere = Filiere::find($id);
            $filiere->delete();
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
