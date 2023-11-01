<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeEtablissementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('type_etablissements')->delete();
        
        \DB::table('type_etablissements')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Université',
                'deleted_at' => NULL,
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Ecole',
                'deleted_at' => NULL,
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Institut',
                'deleted_at' => NULL,
                'created_at' => '2023-10-26 11:48:50',
                'updated_at' => '2023-10-26 11:48:50',
            ),
        ));
        
        
    }
}