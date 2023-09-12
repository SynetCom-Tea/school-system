<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('etablissements')->delete();
        
        \DB::table('etablissements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'CSP Algoza',
                'email' => 'uin@gmail.com',
                'adresse' => 'Recassement',
                'telephone' => '["90099012", "89999000", "90099002"]',
                'ville' => 'Niamey',
                'type_etablissement_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-21 08:03:11',
                'updated_at' => '2023-06-21 08:03:11',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Université Abdou Moumouni',
                'email' => 'uam@gmail.com',
                'adresse' => 'HBD',
                'telephone' => '["96898990", "92231223", "90123456"]',
                'ville' => 'Niamey',
                'type_etablissement_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2023-06-21 08:05:39',
                'updated_at' => '2023-06-21 08:05:39',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'IAI-Niger',
                'email' => 'iai@gmail.com',
                'adresse' => 'Plateau',
                'telephone' => '["89909000", "89900090", "88787878"]',
                'ville' => 'Niamey',
                'type_etablissement_id' => 2,
                'deleted_at' => NULL,
                'created_at' => '2023-06-21 08:08:02',
                'updated_at' => '2023-06-21 08:08:02',
            ),
        ));
    }
}
