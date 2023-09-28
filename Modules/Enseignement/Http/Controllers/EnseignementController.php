<?php

namespace Modules\Enseignement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Enseignement\Entities\Niveau;
use Modules\Enseignement\Entities\Matiere;
use App\Models\Etablissement;
use App\Models\Section;
use App\Models\SystemeLmd;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class EnseignementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // dd(Auth::user());
        return Inertia::render('Admin/accueil');
    }

    public function config($type)
    {
        // dd(Auth::user());

        $table = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $type)->first();
        $id = $table->id;
        $lmd = $table->systeme_lmd_id;
        // dd($table);
        return Inertia::render('Admin/config', [
            'type' => $type,
            'niveaux' => Niveau::where('section_id', $type)->get(),
            // 'matieres' => Matiere::where('etablissement_id', Auth::user()->etablissement_id)->get(),
            'lmd' => $lmd
        ]);
    }

    //Pour la gestion des cruds après la configuration
    public function gestion($type)
    {
        // dd(Auth::user());
        $ets_id = Auth::user()->etablissement_id;
        $table = DB::table('etablissement_section')->where('etablissement_id',$ets_id)->where('section_id',$type)->first();
        $id = $table->id;
        return Inertia::render('Admin/postConfig',[
            'type' => $type,
            'niveaux' => Niveau::where('section_id',$type)->get(),
        ]);
    }

    public function lmd($type)
    {
        return Inertia::render('Admin/lmd', [
            'type' => $type,
            'lmds' => SystemeLmd::all()
        ]);
    }

    public function storelmd(Request $request)
    {
        try {
            //code...

            // dump($request->all());
            $eva = null;
            $ligne = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->first();
            // dd($ligne);
            if ($ligne) {
                if ($request->regime_evaluation == true) {
                    $eva = 1;
                } else {
                    $eva = 0;
                }
                if ($request->lmd) {
                    // dd('eva22:', $eva);
                    DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->update([
                        'systeme_lmd_id' => $request->type_lmd,
                        'regime_evaluation' => $eva
                    ]);
                } else {
                    // dump('user:', Auth::user());
                    // dd('eva:', $eva);
                    DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->update([
                        'systeme_lmd_id' => null,
                        'regime_evaluation' => $eva
                    ]);
                }
            }

            return redirect()->route('admin.config', $request->type);
        } catch (\Throwable $th) {
            //throw $th;

        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
