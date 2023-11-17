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
                'password' => '$2y$10$akrHkbLSE/8hiuksJJ53PuMxjpeRGOGGdd63iL8l4IMZUxrRfy5N.',
                'etablissement_id' => NULL,
                'apprenant_id' => NULL,
                'user_id' => NULL,
                'enseignant_id' => NULL,
                'tuteur_id' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-11-13 11:48:20',
                'updated_at' => '2023-11-13 11:48:20',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'admin@gmail.com',
                'nom' => 'Admin',
                'prenom' => 'IAT',
                'email_verified_at' => NULL,
                'password' => '$2y$10$1taHP6n/mTa7EbsVt0h3juUcUl7BGJqiycr3AHP8jb5mYYczbChQS',
                'etablissement_id' => 1,
                'apprenant_id' => NULL,
                'user_id' => 1,
                'enseignant_id' => NULL,
                'tuteur_id' => NULL,
                'remember_token' => NULL,
                'created_at' => '2023-11-13 11:50:53',
                'updated_at' => '2023-11-13 11:50:53',
            ),
        ));
        
        
    }
}