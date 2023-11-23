<?php

namespace Database\Seeders;

use Modules\GestionNote\Entities\TypeEvaluation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeEvaluationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        TypeEvaluation::create(['libelle' => 'Contrôle']);
        TypeEvaluation::create(['libelle' => 'Interrogation']);
        TypeEvaluation::create(['libelle' => 'Devoir']);
        TypeEvaluation::create(['libelle' => 'Devoir / Devoir Surveillé']);
        TypeEvaluation::create(['libelle' => 'Composition']);
        TypeEvaluation::create(['libelle' => 'Examen']);
        TypeEvaluation::create(['libelle' => 'TP']);
        TypeEvaluation::create(['libelle' => 'Autre']);
    }
}
