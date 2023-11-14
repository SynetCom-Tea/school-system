<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FilieresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('filieres')->delete();
        
        \DB::table('filieres')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Analyste Programmeur',
                'code' => 'AP',
                'etablissement_section_id' => 3,
                'departement_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:24',
                'updated_at' => '2023-11-13 13:49:24',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Informatique et Gestion',
                'code' => 'IG',
                'etablissement_section_id' => 3,
                'departement_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:24',
                'updated_at' => '2023-11-13 13:49:24',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Gestion de projet',
                'code' => 'GP',
                'etablissement_section_id' => 3,
                'departement_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:49:25',
                'updated_at' => '2023-11-13 13:49:25',
            ),
        ));
        
        
    }
}