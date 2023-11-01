<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VersementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('versements')->delete();
        
        \DB::table('versements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => NULL,
                'date_versement' => '2023-10-26',
                'montant' => 200000.0,
                'inscription_id' => 1,
                'frais_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2023-10-26 14:03:25',
                'updated_at' => '2023-10-26 14:03:25',
            ),
        ));
        
        
    }
}