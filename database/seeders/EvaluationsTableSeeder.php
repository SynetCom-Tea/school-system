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
                'date' => '2023-11-02',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'session' => NULL,
                'periode_id' => 1,
                'type_evaluation_id' => 3,
                'enseignement_annee_id' => 7,
                'created_at' => '2023-11-16 16:10:58',
                'updated_at' => '2023-11-16 16:10:58',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'date' => '2023-11-02',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'session' => NULL,
                'periode_id' => 1,
                'type_evaluation_id' => 3,
                'enseignement_annee_id' => 12,
                'created_at' => '2023-11-16 16:10:58',
                'updated_at' => '2023-11-16 16:10:58',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'date' => '2023-11-01',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'session' => NULL,
                'periode_id' => 1,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 7,
                'created_at' => '2023-11-16 16:11:46',
                'updated_at' => '2023-11-16 16:11:46',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'date' => '2023-11-01',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'session' => NULL,
                'periode_id' => 1,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 12,
                'created_at' => '2023-11-16 16:11:46',
                'updated_at' => '2023-11-16 16:11:46',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'date' => '2023-11-11',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'session' => NULL,
                'periode_id' => 1,
                'type_evaluation_id' => 3,
                'enseignement_annee_id' => 14,
                'created_at' => '2023-11-16 16:12:14',
                'updated_at' => '2023-11-16 16:12:14',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'date' => '2023-11-10',
                'notation' => NULL,
                'pourcentage' => NULL,
                'statut' => 0,
                'session' => NULL,
                'periode_id' => 1,
                'type_evaluation_id' => 5,
                'enseignement_annee_id' => 14,
                'created_at' => '2023-11-16 16:12:36',
                'updated_at' => '2023-11-16 16:12:36',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}