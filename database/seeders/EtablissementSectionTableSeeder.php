<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EtablissementSectionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('etablissement_section')->delete();
        
        \DB::table('etablissement_section')->insert(array (
            0 => 
            array (
                'id' => 1,
                'regime_evaluation' => NULL,
                'etablissement_id' => 1,
                'section_id' => 1,
                'systeme_lmd_id' => NULL,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Bakaye/Primaire',
            ),
            1 => 
            array (
                'id' => 2,
                'regime_evaluation' => NULL,
                'etablissement_id' => 1,
                'section_id' => 2,
                'systeme_lmd_id' => NULL,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Bakaye/Secondaire',
            ),
            2 => 
            array (
                'id' => 3,
                'regime_evaluation' => NULL,
                'etablissement_id' => 1,
                'section_id' => 3,
                'systeme_lmd_id' => NULL,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Bakaye/Supérieure',
            ),
            3 => 
            array (
                'id' => 4,
                'regime_evaluation' => NULL,
                'etablissement_id' => 1,
                'section_id' => 4,
                'systeme_lmd_id' => NULL,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Bakaye/Universitaire',
            ),
        ));
        
        
    }
}