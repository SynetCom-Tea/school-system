<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParametresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('parametres')->delete();
        
        \DB::table('parametres')->insert(array (
            0 => 
            array (
                'id' => 1,
                'etablissement_section_id' => 1,
                'nbre_limite_eleve_par_classe' => 5,
                'statut' => NULL,
                'created_at' => '2023-11-13 11:51:50',
                'updated_at' => '2023-11-13 11:51:50',
            ),
            1 => 
            array (
                'id' => 2,
                'etablissement_section_id' => 2,
                'nbre_limite_eleve_par_classe' => 5,
                'statut' => NULL,
                'created_at' => '2023-11-13 12:56:46',
                'updated_at' => '2023-11-13 12:56:46',
            ),
            2 => 
            array (
                'id' => 3,
                'etablissement_section_id' => 3,
                'nbre_limite_eleve_par_classe' => 10,
                'statut' => NULL,
                'created_at' => '2023-11-13 13:42:27',
                'updated_at' => '2023-11-13 13:42:27',
            ),
        ));
        
        
    }
}