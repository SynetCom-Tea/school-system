<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\SystemeLmd;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LmdController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($type)
    {
        $ligne = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $type)->first();

        if($ligne->statutLmd==0){

            return Inertia::render('LMD/lmd', [
                'type' => $type,
                'lmds' => SystemeLmd::all()
            ]);
        }else{
            return redirect()->route('admin.gestion', $type);
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

        $eva = null;
        $ligne = DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->first();
        // dd($request->type_lmd);
        if ($ligne) {
            if ($request->regime_evaluation == true) {
                $eva = 1;
            } else {
                $eva = 0;
            }
            if ($request->lmd) {
                DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->update([
                    'systeme_lmd_id' => $request->type_lmd,
                    'regime_evaluation' => $eva,
                    'statutLmd'=>1,
                ]);
            } else {
                DB::table('etablissement_section')->where('etablissement_id', Auth::user()->etablissement_id)->where('section_id', $request->type)->update([
                    'systeme_lmd_id' => null,
                    'regime_evaluation' => $eva,
                    'statutLmd'=>1,
                ]);
            }
        }
        return redirect()->route('admin.gestion', $request->type);
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
