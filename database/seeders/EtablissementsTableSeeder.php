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
                'name' => 'Groupe IAT',
                'email' => 'iat@niger.edu',
                'adresse' => 'Niamey-niger',
                'telephone' => '"98776655"',
                'ville' => 'NIAMEY',
                'statut' => 1,
                'logo' => 'iat-logo.png',
                'type_etablissement_id' => 2,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 11:50:53',
                'updated_at' => '2023-11-13 11:50:53',
            ),
        ));
        
        
    }
}