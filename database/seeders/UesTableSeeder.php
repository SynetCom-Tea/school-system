<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ues')->delete();
        
        \DB::table('ues')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'UE 101',
                'libelle' => 'UE 101',
                'etablissement_section_id' => 3,
                'created_at' => '2023-11-13 13:58:28',
                'updated_at' => '2023-11-13 13:58:28',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'UE 102',
                'libelle' => 'UE 102',
                'etablissement_section_id' => 3,
                'created_at' => '2023-11-13 13:58:28',
                'updated_at' => '2023-11-13 13:58:28',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'UE 103',
                'libelle' => 'UE 103',
                'etablissement_section_id' => 3,
                'created_at' => '2023-11-13 13:58:28',
                'updated_at' => '2023-11-13 13:58:28',
            ),
        ));
        
        
    }
}