<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;

class FiliereNiveauUeMatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        FiliereNiveauMatiereUe::create([
            'volume_horaire' => 40,
            'coefficient'=>4,
            'matiere_id'=>10,
            'niveau_id'=>21,
            'cycle_filiere_id'=>1
        ]);
        FiliereNiveauMatiereUe::create([
            'volume_horaire' => 50,
            'coefficient'=>5,
            'matiere_id'=>11,
            'niveau_id'=>22,
            'cycle_filiere_id'=>2
        ]);
        FiliereNiveauMatiereUe::create([
            'volume_horaire' => 30,
            'coefficient'=>3,
            'matiere_id'=>12,
            'niveau_id'=>26,
            'cycle_filiere_id'=>3
        ]);
        FiliereNiveauMatiereUe::create([
            'volume_horaire' => 40,
            'coefficient'=>4,
            'matiere_id'=>13,
            'niveau_id'=>27,
            'cycle_filiere_id'=>1
        ]);
    }
}
