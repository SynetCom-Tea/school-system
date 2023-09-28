<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauMatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('niveau_matieres')->insert(array(
            0 =>
            array(
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 1,
                'matiere_id' => 8
            ),
            1 =>
            array(
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 2,
                'matiere_id' => 8
            ),
            2 =>
            array(
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 3,
                'matiere_id' => 8
            ),
            3 =>
            array(
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 4,
                'matiere_id' => 8
            ),
            4 =>
            array(
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 5,
                'matiere_id' => 8
            ),
            5 =>
            array(
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 6,
                'matiere_id' => 8
            ),
            6 =>
            array(
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 7,
                'matiere_id' => 9
            ),
            7 =>
            array(
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 8,
                'matiere_id' => 9
            ),
            8 =>
            array(
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 9,
                'matiere_id' => 9
            ),
            9 =>
            array(
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 10,
                'matiere_id' => 9
            ),
            10 =>
            array(
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 8,
                'matiere_id' => 1
            ),
        ));
        
    }
}
