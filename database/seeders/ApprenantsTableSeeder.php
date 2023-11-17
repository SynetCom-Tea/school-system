<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApprenantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('apprenants')->delete();
        
        \DB::table('apprenants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'matricule' => 'US-GI-01',
                'nom' => 'Issa',
                'prenom' => 'Sani',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '2016-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 12:10:21',
                'updated_at' => '2023-11-13 12:10:21',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'matricule' => 'US-GI-02',
                'nom' => 'Zeinabou',
                'prenom' => 'Kimba',
                'adresse' => NULL,
                'sexe' => 'Féminin',
                'date_naissance' => '2017-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 12:11:36',
                'updated_at' => '2023-11-13 12:11:36',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'matricule' => 'US-GI-03',
                'nom' => 'Fati',
                'prenom' => 'Sabo',
                'adresse' => NULL,
                'sexe' => 'Féminin',
                'date_naissance' => '2018-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 12:16:25',
                'updated_at' => '2023-11-13 12:16:25',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'matricule' => 'US-GI-04',
                'nom' => 'Issa',
                'prenom' => 'Mati',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '2017-06-09',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 12:19:04',
                'updated_at' => '2023-11-13 12:19:04',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'matricule' => 'US-GI-05',
                'nom' => 'Yahaya',
                'prenom' => 'Kaka',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '2008-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 13:20:45',
                'updated_at' => '2023-11-13 13:20:45',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'matricule' => 'US-GI-06',
                'nom' => 'Sakina',
                'prenom' => 'Abdou',
                'adresse' => NULL,
                'sexe' => 'Féminin',
                'date_naissance' => '2003-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 13:22:13',
                'updated_at' => '2023-11-13 13:22:13',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'matricule' => 'US-GI-07',
                'nom' => 'Garba',
                'prenom' => 'Zada',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '2009-01-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 13:24:20',
                'updated_at' => '2023-11-13 13:24:20',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'matricule' => 'US-GI-08',
                'nom' => 'Yacouba',
                'prenom' => 'Idrissa',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '1995-12-01',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 14:10:51',
                'updated_at' => '2023-11-13 14:10:51',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'matricule' => 'US-GI-09',
                'nom' => 'Tinubu',
                'prenom' => 'Bola',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '1993-01-01',
                'lieu_naissance' => 'Nigeria',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 14:12:18',
                'updated_at' => '2023-11-13 14:12:18',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'matricule' => 'US-GI-010',
                'nom' => 'Lamine',
                'prenom' => 'Zeine',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '1979-12-11',
                'lieu_naissance' => 'Niamey',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-13 14:13:49',
                'updated_at' => '2023-11-13 14:13:49',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'matricule' => 'US-GI-011',
                'nom' => 'a',
                'prenom' => 'a',
                'adresse' => NULL,
                'sexe' => 'Masculin',
                'date_naissance' => '1997-01-01',
                'lieu_naissance' => 'a',
                'telephone' => NULL,
                'etablissement_id' => 1,
                'created_at' => '2023-11-14 10:33:37',
                'updated_at' => '2023-11-14 10:33:37',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}