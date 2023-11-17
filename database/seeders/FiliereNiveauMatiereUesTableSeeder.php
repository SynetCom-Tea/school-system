<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FiliereNiveauMatiereUesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('filiere_niveau_matiere_ues')->delete();
        
        \DB::table('filiere_niveau_matiere_ues')->insert(array (
            0 => 
            array (
                'id' => 1,
                'volume_horaire' => '40',
                'coefficient' => '2',
                'cycle_filiere_id' => 1,
                'matiere_id' => 22,
                'niveau_id' => 19,
                'ue_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'volume_horaire' => '40',
                'coefficient' => '2',
                'cycle_filiere_id' => 1,
                'matiere_id' => 23,
                'niveau_id' => 19,
                'ue_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'volume_horaire' => '50',
                'coefficient' => '3',
                'cycle_filiere_id' => 1,
                'matiere_id' => 24,
                'niveau_id' => 19,
                'ue_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'volume_horaire' => '50',
                'coefficient' => '5',
                'cycle_filiere_id' => 1,
                'matiere_id' => 25,
                'niveau_id' => 19,
                'ue_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'volume_horaire' => '30',
                'coefficient' => '3',
                'cycle_filiere_id' => 1,
                'matiere_id' => 26,
                'niveau_id' => 19,
                'ue_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'volume_horaire' => '40',
                'coefficient' => '4',
                'cycle_filiere_id' => 1,
                'matiere_id' => 27,
                'niveau_id' => 19,
                'ue_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'volume_horaire' => '50',
                'coefficient' => '5',
                'cycle_filiere_id' => 1,
                'matiere_id' => 29,
                'niveau_id' => 19,
                'ue_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}