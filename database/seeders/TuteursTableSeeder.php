<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TuteursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tuteurs')->delete();
        
        \DB::table('tuteurs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'Moussa',
                'prenom' => 'Issa',
                'telephone' => '89-98-54-32',
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => 'Masculin',
                'created_at' => '2023-11-13 12:10:22',
                'updated_at' => '2023-11-13 12:10:22',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 12:11:36',
                'updated_at' => '2023-11-13 12:11:36',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 12:16:25',
                'updated_at' => '2023-11-13 12:16:25',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nom' => 'Ali',
                'prenom' => 'Issa',
                'telephone' => '90-88-99-77',
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => 'Masculin',
                'created_at' => '2023-11-13 12:19:04',
                'updated_at' => '2023-11-13 12:19:04',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 13:20:45',
                'updated_at' => '2023-11-13 13:20:45',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 13:22:13',
                'updated_at' => '2023-11-13 13:22:13',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 13:24:20',
                'updated_at' => '2023-11-13 13:24:20',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 14:10:51',
                'updated_at' => '2023-11-13 14:10:51',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 14:12:18',
                'updated_at' => '2023-11-13 14:12:18',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-13 14:13:49',
                'updated_at' => '2023-11-13 14:13:49',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-14 10:33:37',
                'updated_at' => '2023-11-14 10:33:37',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-20 11:23:31',
                'updated_at' => '2023-11-20 11:23:31',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-20 11:32:13',
                'updated_at' => '2023-11-20 11:32:13',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-20 11:32:57',
                'updated_at' => '2023-11-20 11:32:57',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 17,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-20 11:33:45',
                'updated_at' => '2023-11-20 11:33:45',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 18,
                'nom' => NULL,
                'prenom' => NULL,
                'telephone' => NULL,
                'adresse' => NULL,
                'email' => NULL,
                'sexe' => NULL,
                'created_at' => '2023-11-20 11:35:13',
                'updated_at' => '2023-11-20 11:35:13',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}