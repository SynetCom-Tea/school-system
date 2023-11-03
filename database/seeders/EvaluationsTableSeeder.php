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
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 1,
                'created_at' => '2023-11-01 15:49:41',
                'updated_at' => '2023-11-01 15:49:41',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 2,
                'created_at' => '2023-11-01 15:50:05',
                'updated_at' => '2023-11-01 15:50:05',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 3,
                'created_at' => '2023-11-01 15:50:28',
                'updated_at' => '2023-11-01 15:50:28',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 4,
                'created_at' => '2023-11-01 15:50:55',
                'updated_at' => '2023-11-01 15:50:55',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 5,
                'created_at' => '2023-11-01 15:51:21',
                'updated_at' => '2023-11-01 15:51:21',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 6,
                'created_at' => '2023-11-01 15:51:51',
                'updated_at' => '2023-11-01 15:51:51',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 7,
                'created_at' => '2023-11-01 15:52:21',
                'updated_at' => '2023-11-01 15:52:21',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 8,
                'created_at' => '2023-11-01 15:52:54',
                'updated_at' => '2023-11-01 15:52:54',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 9,
                'created_at' => '2023-11-01 15:53:38',
                'updated_at' => '2023-11-01 15:53:38',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 10,
                'created_at' => '2023-11-01 15:54:26',
                'updated_at' => '2023-11-01 15:54:26',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 11,
                'created_at' => '2023-11-01 15:55:01',
                'updated_at' => '2023-11-01 15:55:01',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 12,
                'created_at' => '2023-11-01 15:55:33',
                'updated_at' => '2023-11-01 15:55:33',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 13,
                'created_at' => '2023-11-01 15:56:28',
                'updated_at' => '2023-11-01 15:56:28',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'date' => '2023-10-04',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'periode_id' => 3,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 14,
                'created_at' => '2023-11-01 15:56:49',
                'updated_at' => '2023-11-01 15:56:49',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}