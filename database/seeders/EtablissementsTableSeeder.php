<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EtablissementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('etablissements')->delete();
        
        \DB::table('etablissements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Bakaye',
                'email' => 'bakaye@gmail.com',
                'adresse' => 'Bobiel',
                'telephone' => '"96123654"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => NULL,
                'type_etablissement_id' => 2,
                'deleted_at' => NULL,
                'created_at' => '2023-10-26 12:09:57',
                'updated_at' => '2023-10-26 12:09:57',
            ),
        ));
        
        
    }
}