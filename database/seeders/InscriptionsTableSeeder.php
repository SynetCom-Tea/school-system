<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InscriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('inscriptions')->delete();
        
        \DB::table('inscriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'US-P-2023-2024-Cd-1',
                'date_inscription' => '2023-10-26',
                'apprenant_id' => 1,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-26 14:00:39',
                'updated_at' => '2023-10-26 14:00:39',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'US-P-2023-2024-Cd-2',
                'date_inscription' => '2023-10-26',
                'apprenant_id' => 2,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-26 14:06:11',
                'updated_at' => '2023-10-26 14:06:11',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'US-P-2023-2024-Cd-3',
                'date_inscription' => '2023-10-27',
                'apprenant_id' => 3,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-27 05:12:57',
                'updated_at' => '2023-10-27 05:12:57',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'US-P-2023-2024-Cd-4',
                'date_inscription' => '2023-10-27',
                'apprenant_id' => 4,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-27 05:14:08',
                'updated_at' => '2023-10-27 05:14:08',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'US-P-2023-2024-Cd-5',
                'date_inscription' => '2023-10-27',
                'apprenant_id' => 5,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-27 05:15:31',
                'updated_at' => '2023-10-27 05:15:31',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'US-P-2023-2024-Cd-6',
                'date_inscription' => '2023-10-27',
                'apprenant_id' => 6,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-27 05:17:52',
                'updated_at' => '2023-10-27 05:17:52',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'US-P-2023-2024-Cd-7',
                'date_inscription' => '2023-10-27',
                'apprenant_id' => 7,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-27 05:19:25',
                'updated_at' => '2023-10-27 05:19:25',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'US-P-2023-2024-CP-1',
                'date_inscription' => '2023-10-27',
                'apprenant_id' => 8,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 2,
                'statut' => 0,
                'created_at' => '2023-10-27 05:20:29',
                'updated_at' => '2023-10-27 05:20:29',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'US-P-2023-2024-Cd-8',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 9,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 07:17:31',
                'updated_at' => '2023-10-28 07:17:31',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'US-P-2023-2024-Cd-9',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 10,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 07:21:17',
                'updated_at' => '2023-10-28 07:21:17',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'US-P-2023-2024-Cd-10',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 11,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 07:23:11',
                'updated_at' => '2023-10-28 07:23:11',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'US-P-2023-2024-Cd-11',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 12,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 07:24:47',
                'updated_at' => '2023-10-28 07:24:47',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'US-P-2023-2024-Cd-12',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 13,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 07:26:05',
                'updated_at' => '2023-10-28 07:26:05',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'US-P-2023-2024-Cd-13',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 14,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 07:30:11',
                'updated_at' => '2023-10-28 07:30:11',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'US-P-2023-2024-Cd-14',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 15,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 14:14:54',
                'updated_at' => '2023-10-28 14:14:54',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'US-P-2023-2024-Cd-15',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 16,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 14:18:00',
                'updated_at' => '2023-10-28 14:18:00',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'US-P-2023-2024-Cd-16',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 17,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-10-28 14:19:43',
                'updated_at' => '2023-10-28 14:19:43',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'US-P-2023-2024-CP-2',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 18,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 2,
                'statut' => 0,
                'created_at' => '2023-10-28 14:21:26',
                'updated_at' => '2023-10-28 14:21:26',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'US-P-2023-2024-CP-3',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 19,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 2,
                'statut' => 0,
                'created_at' => '2023-10-28 14:23:24',
                'updated_at' => '2023-10-28 14:23:24',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'US-P-2023-2024-CP-4',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 20,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 2,
                'statut' => 0,
                'created_at' => '2023-10-28 14:26:05',
                'updated_at' => '2023-10-28 14:26:05',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'US-P-2023-2024-CP-5',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 21,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 2,
                'statut' => 0,
                'created_at' => '2023-10-28 14:27:37',
                'updated_at' => '2023-10-28 14:27:37',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'US-P-2023-2024-CE1-1',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 22,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 3,
                'statut' => 0,
                'created_at' => '2023-10-28 15:09:28',
                'updated_at' => '2023-10-28 15:09:28',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'US-P-2023-2024-CE1-2',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 23,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 3,
                'statut' => 0,
                'created_at' => '2023-10-28 15:12:18',
                'updated_at' => '2023-10-28 15:12:18',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'US-P-2023-2024-CE1-3',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 24,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 3,
                'statut' => 0,
                'created_at' => '2023-10-28 15:13:52',
                'updated_at' => '2023-10-28 15:13:52',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'US-P-2023-2024-CE1-4',
                'date_inscription' => '2023-10-28',
                'apprenant_id' => 25,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 3,
                'statut' => 0,
                'created_at' => '2023-10-28 15:15:19',
                'updated_at' => '2023-10-28 15:15:19',
            ),
        ));
        
        
    }
}