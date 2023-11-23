<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegimeEvaluationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('regime_evaluations')->delete();
        
        
        \DB::table('regime_evaluations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type_evaluation_id' => 6,
                'systeme_lmd_id' => 1,
                'pourcentage' => 0.7,
                'created_at' => '2023-11-13 11:48:14',
                'updated_at' => '2023-11-13 11:48:14',
            ),
            1 => 
            array (
                'id' => 2,
                'type_evaluation_id' => 5,
                'systeme_lmd_id' => 1,
                'pourcentage' => 0.2,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
            2 => 
            array (
                'id' => 3,
                'type_evaluation_id' => 7,
                'systeme_lmd_id' => 1,
                'pourcentage' => 0.2,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
            3 => 
            array (
                'id' => 4,
                'type_evaluation_id' => 8,
                'systeme_lmd_id' => 1,
                'pourcentage' => 0.1,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
            4 => 
            array (
                'id' => 5,
                'type_evaluation_id' => 5,
                'systeme_lmd_id' => 2,
                'pourcentage' => 0.8,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
            5 => 
            array (
                'id' => 6,
                'type_evaluation_id' => 8,
                'systeme_lmd_id' => 2,
                'pourcentage' => 0.2,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
        ));
    }
}