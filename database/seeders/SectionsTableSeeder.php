<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Primaire',
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Secondaire',
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => 'Supérieure',
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => 'Universitaire',
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}