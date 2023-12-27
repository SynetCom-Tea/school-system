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
            // 6 => 
            // array (
            //     'id' => 7,
            //     'matricule' => 'MAT/27E',
            //     'nom' => 'Daouda',
            //     'prenom' => 'Arji',
            //     'sex' => 'Masculin',
            //     'date_naissance' => '1980-06-20',
            //     'lieu_naissance' => 'Agadez',
            //     'telephone' => '90086761',
            //     'compte' => NULL,
            //     'etablissement_id' => 2,
            //     'created_at' => '2023-11-20 10:13:12',
            //     'updated_at' => '2023-11-20 10:13:12',
            //     'deleted_at' => NULL,
            //     'NomComplet' => 'Daouda Arji',
            //     'date_lieu_nais' => '1980-06-20 à Agadez',
            // ),
            // 7 => 
            // array (
            //     'id' => 8,
            //     'matricule' => 'MAT/28E',
            //     'nom' => 'Mansour',
            //     'prenom' => 'Issa',
            //     'sex' => 'Masculin',
            //     'date_naissance' => '1988-06-08',
            //     'lieu_naissance' => 'Diffa',
            //     'telephone' => '90892211',
            //     'compte' => NULL,
            //     'etablissement_id' => 2,
            //     'created_at' => '2023-11-20 10:15:16',
            //     'updated_at' => '2023-11-20 10:15:16',
            //     'deleted_at' => NULL,
            //     'NomComplet' => 'Mansour Issa',
            //     'date_lieu_nais' => '1988-06-08 à Diffa',
            // ),
            // 8 => 
            // array (
            //     'id' => 9,
            //     'matricule' => 'MAT/29E',
            //     'nom' => 'Maimouna',
            //     'prenom' => 'Idrisse',
            //     'sex' => 'Féminin',
            //     'date_naissance' => '1977-10-12',
            //     'lieu_naissance' => 'Niamey',
            //     'telephone' => '89001289',
            //     'compte' => NULL,
            //     'etablissement_id' => 2,
            //     'created_at' => '2023-11-20 10:16:43',
            //     'updated_at' => '2023-11-20 10:16:43',
            //     'deleted_at' => NULL,
            //     'NomComplet' => 'Maimouna Idrisse',
            //     'date_lieu_nais' => '1977-10-12 à Niamey',
            // ),
            // 9 => 
            // array (
            //     'id' => 10,
            //     'matricule' => 'MAT/210E',
            //     'nom' => 'Illiassou',
            //     'prenom' => 'Abdoul Moumouni',
            //     'sex' => 'Masculin',
            //     'date_naissance' => '1984-09-18',
            //     'lieu_naissance' => 'Kano',
            //     'telephone' => '89127837',
            //     'compte' => NULL,
            //     'etablissement_id' => 2,
            //     'created_at' => '2023-11-20 10:19:11',
            //     'updated_at' => '2023-11-20 10:19:11',
            //     'deleted_at' => NULL,
            //     'NomComplet' => 'Illiassou Abdoul Moumouni',
            //     'date_lieu_nais' => '1984-09-18 à Kano',
            // ),
            // 10 => 
            // array (
            //     'id' => 11,
            //     'matricule' => 'MAT/211E',
            //     'nom' => 'Hassane',
            //     'prenom' => 'Bizo',
            //     'sex' => 'Masculin',
            //     'date_naissance' => '1977-10-12',
            //     'lieu_naissance' => 'Tera',
            //     'telephone' => '90127822',
            //     'compte' => NULL,
            //     'etablissement_id' => 2,
            //     'created_at' => '2023-11-20 10:22:50',
            //     'updated_at' => '2023-11-20 10:22:50',
            //     'deleted_at' => NULL,
            //     'NomComplet' => 'Hassane Bizo',
            //     'date_lieu_nais' => '1977-10-12 à Tera',
            // ),
            // 11 => 
            // array (
            //     'id' => 12,
            //     'matricule' => 'MAT/212E',
            //     'nom' => 'Nafissa',
            //     'prenom' => 'Alo',
            //     'sex' => 'Féminin',
            //     'date_naissance' => '1992-10-20',
            //     'lieu_naissance' => 'Niamey',
            //     'telephone' => '89221100',
            //     'compte' => NULL,
            //     'etablissement_id' => 2,
            //     'created_at' => '2023-11-20 10:24:06',
            //     'updated_at' => '2023-11-20 10:24:06',
            //     'deleted_at' => NULL,
            //     'NomComplet' => 'Nafissa Alo',
            //     'date_lieu_nais' => '1992-10-20 à Niamey',
            // ),
        ));
        
        
    }
}