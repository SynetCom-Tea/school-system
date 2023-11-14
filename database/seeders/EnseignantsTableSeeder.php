<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnseignantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('enseignants')->delete();
        
        \DB::table('enseignants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'matricule' => 'MAT/11E',
                'nom' => 'Moustaou',
                'prenom' => 'Alou',
                'sex' => 'Masculin',
                'date_naissance' => '1998-01-12',
                'lieu_naissance' => 'Niamey',
                'telephone' => '98368231',
                'compte' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 12:04:29',
                'updated_at' => '2023-11-13 12:04:29',
                'deleted_at' => NULL,
                'NomComplet' => 'Moustaou Alou',
                'date_lieu_nais' => '1998-01-12 à Niamey',
            ),
            1 => 
            array (
                'id' => 2,
                'matricule' => 'MAT/12E',
                'nom' => 'Manzo',
                'prenom' => 'Ali',
                'sex' => 'Masculin',
                'date_naissance' => '1999-03-12',
                'lieu_naissance' => 'Flangoutou',
                'telephone' => '98675432',
                'compte' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 12:07:55',
                'updated_at' => '2023-11-13 12:07:55',
                'deleted_at' => NULL,
                'NomComplet' => 'Manzo Ali',
                'date_lieu_nais' => '1999-03-12 à Flangoutou',
            ),
            2 => 
            array (
                'id' => 3,
                'matricule' => 'MAT/13E',
                'nom' => 'Kouli',
                'prenom' => 'Id',
                'sex' => 'Masculin',
                'date_naissance' => '1998-12-11',
                'lieu_naissance' => 'Frangoutou',
                'telephone' => '98786543',
                'compte' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 13:14:01',
                'updated_at' => '2023-11-13 13:14:01',
                'deleted_at' => NULL,
                'NomComplet' => 'Kouli Id',
                'date_lieu_nais' => '1998-12-11 à Frangoutou',
            ),
            3 => 
            array (
                'id' => 4,
                'matricule' => 'MAT/14E',
                'nom' => 'Tichou',
                'prenom' => 'Meda',
                'sex' => 'Féminin',
                'date_naissance' => '1998-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => '98982634',
                'compte' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 13:16:48',
                'updated_at' => '2023-11-13 13:16:48',
                'deleted_at' => NULL,
                'NomComplet' => 'Tichou Meda',
                'date_lieu_nais' => '1998-01-01 à Niamey',
            ),
            4 => 
            array (
                'id' => 5,
                'matricule' => 'MAT/15E',
                'nom' => 'Souké',
                'prenom' => 'Sidiki',
                'sex' => 'Masculin',
                'date_naissance' => '1989-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => '98273652',
                'compte' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 14:06:09',
                'updated_at' => '2023-11-13 14:06:09',
                'deleted_at' => NULL,
                'NomComplet' => 'Souké Sidiki',
                'date_lieu_nais' => '1989-01-01 à Niamey',
            ),
            5 => 
            array (
                'id' => 6,
                'matricule' => 'MAT/16E',
                'nom' => 'Boulama',
                'prenom' => 'Gnandou',
                'sex' => 'Masculin',
                'date_naissance' => '1997-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => '98763543',
                'compte' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 14:08:25',
                'updated_at' => '2023-11-13 14:08:25',
                'deleted_at' => NULL,
                'NomComplet' => 'Boulama Gnandou',
                'date_lieu_nais' => '1997-01-01 à Niamey',
            ),
        ));
        
        
    }
}