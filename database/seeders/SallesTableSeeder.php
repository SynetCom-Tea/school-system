<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SallesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('salles')->delete();
        
        \DB::table('salles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '001',
                'libelle' => 'Salle d\'informatique',
                'etablissement_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '002',
                'libelle' => 'Salle TP',
                'etablissement_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}