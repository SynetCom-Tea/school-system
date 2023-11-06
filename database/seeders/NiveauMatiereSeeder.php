<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauMatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('niveau_matieres')->delete();

        \DB::table('niveau_matieres')->insert(array(
            0 =>
            array(
                'id' => 1,
                'volume_horaire' => 50,
                'coefficient' => 3,
                'niveau_id' => 10,
                'notation'=>20,
                'matiere_id' => 1,

            ),
            1 =>
            array(
                'id' => 2,
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 10,
                'notation'=>20,
                'matiere_id' => 2,
            ),
            2 =>
            array(
                'id' => 3,
                'volume_horaire' => 60,
                'coefficient' => 5,
                'niveau_id' => 10,
                'notation'=>20,
                'matiere_id' => 3,

            ),
            3 =>
            array(
                'id' => 4,
                'volume_horaire' => 30,
                'coefficient' => 2,
                'niveau_id' => 10,
                'notation'=>20,
                'matiere_id' => 9,

            ),
            4 =>
            array(
                'id' => 5,
                'volume_horaire' => 20,
                'coefficient' => 1,
                'niveau_id' => 3,
                'matiere_id' => 8,
                'notation'=>10,

            ),
            5 =>
            array(
                'id' => 6,
                'volume_horaire' => 40,
                'coefficient' => 2,
                'niveau_id' => 3,
                'matiere_id' => 6,
                'notation'=>20,

            ),
            6 =>
            array(
                'id' => 7,
                'volume_horaire' => 30,
                'coefficient' => 2,
                'niveau_id' => 3,
                'matiere_id' => 7,
                'notation'=>20,
            ),
            7 =>
            array(
                'id' => 8,
                'volume_horaire' => 30,
                'coefficient' => 2,
                'niveau_id' => 3,
                'matiere_id' => 4,
                'notation'=>20,
            ),
            8 =>
            array(
                'id' => 9,
                'volume_horaire' => 30,
                'coefficient' => 2,
                'niveau_id' => 3,
                'matiere_id' => 5,
                'notation'=>20,
            ),
        ));
    }
}
