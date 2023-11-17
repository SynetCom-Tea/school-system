<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('notes')->delete();
        
        \DB::table('notes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'date' => '2023-11-16',
                'note' => 18.0,
                'apprenant_id' => 5,
                'evaluation_id' => 1,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:15:13',
                'updated_at' => '2023-11-16 16:15:13',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'date' => '2023-11-16',
                'note' => 8.0,
                'apprenant_id' => 6,
                'evaluation_id' => 1,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:15:13',
                'updated_at' => '2023-11-16 16:15:13',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'date' => '2023-11-16',
                'note' => 15.0,
                'apprenant_id' => 7,
                'evaluation_id' => 1,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:15:13',
                'updated_at' => '2023-11-16 16:15:13',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'date' => '2023-11-16',
                'note' => 12.0,
                'apprenant_id' => 5,
                'evaluation_id' => 2,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:15:44',
                'updated_at' => '2023-11-16 16:15:44',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'date' => '2023-11-16',
                'note' => 8.0,
                'apprenant_id' => 6,
                'evaluation_id' => 2,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:15:44',
                'updated_at' => '2023-11-16 16:15:44',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'date' => '2023-11-16',
                'note' => 15.0,
                'apprenant_id' => 7,
                'evaluation_id' => 2,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:15:44',
                'updated_at' => '2023-11-16 16:15:44',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'date' => '2023-11-16',
                'note' => 15.0,
                'apprenant_id' => 5,
                'evaluation_id' => 3,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:16:55',
                'updated_at' => '2023-11-16 16:16:55',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'date' => '2023-11-16',
                'note' => 8.0,
                'apprenant_id' => 6,
                'evaluation_id' => 3,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:16:55',
                'updated_at' => '2023-11-16 16:16:55',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'date' => '2023-11-16',
                'note' => 19.0,
                'apprenant_id' => 7,
                'evaluation_id' => 3,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:16:55',
                'updated_at' => '2023-11-16 16:16:55',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'date' => '2023-11-16',
                'note' => 18.0,
                'apprenant_id' => 5,
                'evaluation_id' => 4,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:17:22',
                'updated_at' => '2023-11-16 16:17:22',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'date' => '2023-11-16',
                'note' => 9.0,
                'apprenant_id' => 6,
                'evaluation_id' => 4,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:17:22',
                'updated_at' => '2023-11-16 16:17:22',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'date' => '2023-11-16',
                'note' => 12.0,
                'apprenant_id' => 7,
                'evaluation_id' => 4,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:17:22',
                'updated_at' => '2023-11-16 16:17:22',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'date' => '2023-11-16',
                'note' => 9.0,
                'apprenant_id' => 5,
                'evaluation_id' => 5,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:18:22',
                'updated_at' => '2023-11-16 16:18:22',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'date' => '2023-11-16',
                'note' => 18.0,
                'apprenant_id' => 6,
                'evaluation_id' => 5,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:18:22',
                'updated_at' => '2023-11-16 16:18:22',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'date' => '2023-11-16',
                'note' => 5.0,
                'apprenant_id' => 7,
                'evaluation_id' => 5,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:18:22',
                'updated_at' => '2023-11-16 16:18:22',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'date' => '2023-11-16',
                'note' => 16.0,
                'apprenant_id' => 5,
                'evaluation_id' => 6,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:18:58',
                'updated_at' => '2023-11-16 16:18:58',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'date' => '2023-11-16',
                'note' => 11.0,
                'apprenant_id' => 6,
                'evaluation_id' => 6,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:18:58',
                'updated_at' => '2023-11-16 16:18:58',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'date' => '2023-11-16',
                'note' => 17.0,
                'apprenant_id' => 7,
                'evaluation_id' => 6,
                'user_id' => NULL,
                'statut' => 1,
                'created_at' => '2023-11-16 16:18:58',
                'updated_at' => '2023-11-16 16:18:58',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}