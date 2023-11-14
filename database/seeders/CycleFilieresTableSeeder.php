<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CycleFilieresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cycle_filieres')->delete();
        
        \DB::table('cycle_filieres')->insert(array (
            0 => 
            array (
                'id' => 1,
                'cycle_id' => 2,
                'filiere_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:24',
                'updated_at' => '2023-11-13 13:49:24',
                'code' => 'Analyste Programmeur/1er cycle',
            ),
            1 => 
            array (
                'id' => 2,
                'cycle_id' => 3,
                'filiere_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:24',
                'updated_at' => '2023-11-13 13:49:24',
                'code' => 'Analyste Programmeur/2e cycle',
            ),
            2 => 
            array (
                'id' => 3,
                'cycle_id' => 1,
                'filiere_id' => 2,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:24',
                'updated_at' => '2023-11-13 13:49:24',
                'code' => 'Informatique et Gestion/Cycle Moyen',
            ),
            3 => 
            array (
                'id' => 4,
                'cycle_id' => 2,
                'filiere_id' => 2,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:24',
                'updated_at' => '2023-11-13 13:49:24',
                'code' => 'Informatique et Gestion/1er cycle',
            ),
            4 => 
            array (
                'id' => 5,
                'cycle_id' => 2,
                'filiere_id' => 3,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:25',
                'updated_at' => '2023-11-13 13:49:25',
                'code' => 'Gestion de projet/1er cycle',
            ),
            5 => 
            array (
                'id' => 6,
                'cycle_id' => 3,
                'filiere_id' => 3,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:25',
                'updated_at' => '2023-11-13 13:49:25',
                'code' => 'Gestion de projet/2e cycle',
            ),
        ));
        
        
    }
}