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
                'devoir_continu' => NULL,
                'etablissement_id' => 1,
                'section_id' => 1,
                'systeme_lmd_id' => NULL,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'nbre_credit'=>12,
                'regime_validation_id'=>1,
                'code' => 'Groupe IAT/Primaire',
                'statutLmd' => 0,
            ),
            1 =>
            array (
                'id' => 2,
                'devoir_continu' => NULL,
                'etablissement_id' => 1,
                'section_id' => 2,
                'systeme_lmd_id' => NULL,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'nbre_credit'=>12,
                'regime_validation_id'=>1,
                'code' => 'Groupe IAT/Secondaire',
                'statutLmd' => 0,
            ),
            2 =>
            array (
                'id' => 3,
                'devoir_continu' => 1,
                'etablissement_id' => 1,
                'section_id' => 3,
                'systeme_lmd_id' => 1,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'nbre_credit'=>12,
                'regime_validation_id'=>1,
                'code' => 'Groupe IAT/Supérieure',
                'statutLmd' => 1,
            ),
            3 =>
            array (
                'id' => 4,
                'devoir_continu' => 1,
                'etablissement_id' => 2,
                'section_id' => 3,
                'systeme_lmd_id' => 1,
                'configuration' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'nbre_credit'=>12,
                'regime_validation_id'=>1,
                'code' => 'Hetech/Supérieure',
                'statutLmd' => 1,
            ),
        ));


    }
}
