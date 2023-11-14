<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApprenantTuteursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('apprenant_tuteurs')->delete();
        
        \DB::table('apprenant_tuteurs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'apprenant_id' => 1,
                'tuteur_id' => 1,
                'created_at' => '2023-11-13 12:10:22',
                'updated_at' => '2023-11-13 12:10:22',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'apprenant_id' => 2,
                'tuteur_id' => 2,
                'created_at' => '2023-11-13 12:11:36',
                'updated_at' => '2023-11-13 12:11:36',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'apprenant_id' => 3,
                'tuteur_id' => 3,
                'created_at' => '2023-11-13 12:16:25',
                'updated_at' => '2023-11-13 12:16:25',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'apprenant_id' => 4,
                'tuteur_id' => 4,
                'created_at' => '2023-11-13 12:19:04',
                'updated_at' => '2023-11-13 12:19:04',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'apprenant_id' => 5,
                'tuteur_id' => 5,
                'created_at' => '2023-11-13 13:20:45',
                'updated_at' => '2023-11-13 13:20:45',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'apprenant_id' => 6,
                'tuteur_id' => 6,
                'created_at' => '2023-11-13 13:22:13',
                'updated_at' => '2023-11-13 13:22:13',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'apprenant_id' => 7,
                'tuteur_id' => 7,
                'created_at' => '2023-11-13 13:24:20',
                'updated_at' => '2023-11-13 13:24:20',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'apprenant_id' => 8,
                'tuteur_id' => 8,
                'created_at' => '2023-11-13 14:10:51',
                'updated_at' => '2023-11-13 14:10:51',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'apprenant_id' => 9,
                'tuteur_id' => 9,
                'created_at' => '2023-11-13 14:12:18',
                'updated_at' => '2023-11-13 14:12:18',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'apprenant_id' => 10,
                'tuteur_id' => 10,
                'created_at' => '2023-11-13 14:13:49',
                'updated_at' => '2023-11-13 14:13:49',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'apprenant_id' => 11,
                'tuteur_id' => 11,
                'created_at' => '2023-11-14 10:33:37',
                'updated_at' => '2023-11-14 10:33:37',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}