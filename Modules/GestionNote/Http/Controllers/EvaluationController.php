<?php

namespace Modules\GestionNote\Http\Controllers;

use Modules\GestionNote\Entities\Periode;
use Modules\GestionNote\Entities\TypeEvaluation;
use Modules\GestionNote\Entities\Evaluation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Inertia\Inertia;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $periode = Periode::all();
        $typeEvaluation = TypeEvaluation::all();
        $evaluation = Evaluation::all();
        return Inertia::render('gestion-note/evaluation/index', [
            'periode' => $periode,
            'typeEvaluation'=>$typeEvaluation,
            'evaluation'=>$evaluation,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('gestionnote::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        request()->validate([

            'date' => 'required|date_format:d/m/Y',
            'pourcentage' => 'required|string|max:255',
            'periode_id' => [
                'required',
                'exists:Periode,id',
            ],
            'type_evaluation_id' => [
                'required',
                'exists:TypeEvaluation,id',
            ],
        ]);
        $data = ['date' => $request->date,'pourcentage' => $request->pourcentage,'periode_id' => $request->periode_id,'type_evaluation_id' => $request->etype_evaluation_id ?? 'RAS'];
        dd($data);
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gestionnote::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('gestionnote::edit');
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
