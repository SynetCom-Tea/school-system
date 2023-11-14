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
                'date_versement' => '2023-11-13',
                'montant' => 3000.0,
                'inscription_id' => 1,
                'frais_id' => 3,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 12:45:26',
                'updated_at' => '2023-11-13 12:45:26',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 100000.0,
                'inscription_id' => 1,
                'frais_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 12:45:26',
                'updated_at' => '2023-11-13 12:45:26',
            ),
            2 => 
            array (
                'id' => 3,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 3000.0,
                'inscription_id' => 2,
                'frais_id' => 3,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 12:45:50',
                'updated_at' => '2023-11-13 12:45:50',
            ),
            3 => 
            array (
                'id' => 4,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 100000.0,
                'inscription_id' => 2,
                'frais_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 12:45:50',
                'updated_at' => '2023-11-13 12:45:50',
            ),
            4 => 
            array (
                'id' => 5,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 200000.0,
                'inscription_id' => 5,
                'frais_id' => 13,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:24:45',
                'updated_at' => '2023-11-13 13:24:45',
            ),
            5 => 
            array (
                'id' => 6,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 5000.0,
                'inscription_id' => 5,
                'frais_id' => 25,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:24:45',
                'updated_at' => '2023-11-13 13:24:45',
            ),
            6 => 
            array (
                'id' => 7,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 200000.0,
                'inscription_id' => 6,
                'frais_id' => 13,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:25:06',
                'updated_at' => '2023-11-13 13:25:06',
            ),
            7 => 
            array (
                'id' => 8,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 5000.0,
                'inscription_id' => 6,
                'frais_id' => 25,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:25:07',
                'updated_at' => '2023-11-13 13:25:07',
            ),
            8 => 
            array (
                'id' => 9,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 200000.0,
                'inscription_id' => 7,
                'frais_id' => 13,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:25:20',
                'updated_at' => '2023-11-13 13:25:20',
            ),
            9 => 
            array (
                'id' => 10,
                'libelle' => NULL,
                'date_versement' => '2023-11-13',
                'montant' => 5000.0,
                'inscription_id' => 7,
                'frais_id' => 25,
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 13:25:20',
                'updated_at' => '2023-11-13 13:25:20',
            ),
            10 => 
            array (
                'id' => 14,
                'libelle' => NULL,
                'date_versement' => '2023-11-14',
                'montant' => 10000.0,
                'inscription_id' => 9,
                'frais_id' => 37,
                'deleted_at' => NULL,
                'created_at' => '2023-11-14 09:42:23',
                'updated_at' => '2023-11-14 09:42:23',
            ),
            11 => 
            array (
                'id' => 15,
                'libelle' => NULL,
                'date_versement' => '2023-11-14',
                'montant' => 650000.0,
                'inscription_id' => 9,
                'frais_id' => 42,
                'deleted_at' => NULL,
                'created_at' => '2023-11-14 09:42:23',
                'updated_at' => '2023-11-14 09:42:23',
            ),
        ));
        
        
    }
}