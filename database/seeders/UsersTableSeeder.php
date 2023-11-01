<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'super-admin@univers-school.com',
                'nom' => 'super',
                'prenom' => 'Administrateur',
                'email_verified_at' => NULL,
                'password' => '$2y$10$453UzcCnPH/kBR7cSXuk2uzlh3yZAAv3bbcyzX3tp2Ly5lRwSSRna',
                'etablissement_id' => NULL,
                'apprenant_id' => NULL,
                'user_id' => NULL,
                'enseignant_id' => NULL,
                'tuteur_id' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-11-01 11:28:42',
                'updated_at' => '2023-11-01 11:28:42',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'al@g.ml',
                'nom' => 'Ali Gambo',
                'prenom' => 'Mamane',
                'email_verified_at' => NULL,
                'password' => '$2y$10$YrAVrMjtTuaLD0E8jc53C.nZFRa7r1MusvcD1Gzr4iUKJwpKr7yui',
                'etablissement_id' => 1,
                'apprenant_id' => NULL,
                'user_id' => 1,
                'enseignant_id' => NULL,
                'tuteur_id' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-10-26 12:09:58',
                'updated_at' => '2023-10-26 12:09:58',
            ),
        ));
        
        
    }
}