<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApprenantClasseAnneesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('apprenant_classe_annees')->delete();
        
        \DB::table('apprenant_classe_annees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'classe_annee_id' => 1,
                'apprenant_id' => 1,
                'created_at' => '2023-11-13 12:10:22',
                'updated_at' => '2023-11-13 12:10:22',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'classe_annee_id' => 1,
                'apprenant_id' => 2,
                'created_at' => '2023-11-13 12:11:36',
                'updated_at' => '2023-11-13 12:11:36',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'classe_annee_id' => 1,
                'apprenant_id' => 3,
                'created_at' => '2023-11-13 12:16:25',
                'updated_at' => '2023-11-13 12:16:25',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'classe_annee_id' => 1,
                'apprenant_id' => 4,
                'created_at' => '2023-11-13 12:19:04',
                'updated_at' => '2023-11-13 12:19:04',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'classe_annee_id' => 15,
                'apprenant_id' => 5,
                'created_at' => '2023-11-13 13:20:45',
                'updated_at' => '2023-11-13 13:20:45',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'classe_annee_id' => 15,
                'apprenant_id' => 6,
                'created_at' => '2023-11-13 13:22:13',
                'updated_at' => '2023-11-13 13:22:13',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'classe_annee_id' => 15,
                'apprenant_id' => 7,
                'created_at' => '2023-11-13 13:24:20',
                'updated_at' => '2023-11-13 13:24:20',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'classe_annee_id' => 20,
                'apprenant_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'classe_annee_id' => 20,
                'apprenant_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'classe_annee_id' => 20,
                'apprenant_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'classe_annee_id' => 20,
                'apprenant_id' => 11,
                'created_at' => '2023-11-14 10:33:37',
                'updated_at' => '2023-11-14 10:33:37',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                'classe_annee_id' => 36,
                'apprenant_id' => 14,
                'created_at' => '2023-11-20 11:23:31',
                'updated_at' => '2023-11-20 11:23:31',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                'classe_annee_id' => 36,
                'apprenant_id' => 15,
                'created_at' => '2023-11-20 11:32:13',
                'updated_at' => '2023-11-20 11:32:13',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                'classe_annee_id' => 36,
                'apprenant_id' => 16,
                'created_at' => '2023-11-20 11:32:57',
                'updated_at' => '2023-11-20 11:32:57',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 17,
                'classe_annee_id' => 36,
                'apprenant_id' => 17,
                'created_at' => '2023-11-20 11:33:45',
                'updated_at' => '2023-11-20 11:33:45',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 18,
                'classe_annee_id' => 36,
                'apprenant_id' => 18,
                'created_at' => '2023-11-20 11:35:13',
                'updated_at' => '2023-11-20 11:35:13',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}