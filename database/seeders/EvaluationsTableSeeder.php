<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EvaluationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('evaluations')->delete();
        
        \DB::table('evaluations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 1,
                'created_at' => '2023-11-01 13:18:15',
                'updated_at' => '2023-11-01 13:18:15',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 2,
                'created_at' => '2023-11-01 13:18:53',
                'updated_at' => '2023-11-01 13:18:53',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 3,
                'created_at' => '2023-11-01 13:19:29',
                'updated_at' => '2023-11-01 13:19:29',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 4,
                'created_at' => '2023-11-01 13:20:09',
                'updated_at' => '2023-11-01 13:20:09',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 5,
                'created_at' => '2023-11-01 13:20:46',
                'updated_at' => '2023-11-01 13:20:46',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 6,
                'created_at' => '2023-11-01 13:21:21',
                'updated_at' => '2023-11-01 13:21:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 7,
                'created_at' => '2023-11-01 13:22:01',
                'updated_at' => '2023-11-01 13:22:01',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 8,
                'created_at' => '2023-11-01 13:22:42',
                'updated_at' => '2023-11-01 13:22:42',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 9,
                'created_at' => '2023-11-01 13:23:22',
                'updated_at' => '2023-11-01 13:23:22',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'date' => '2023-10-04',
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 10,
                'created_at' => '2023-11-01 13:25:26',
                'updated_at' => '2023-11-01 13:25:26',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}