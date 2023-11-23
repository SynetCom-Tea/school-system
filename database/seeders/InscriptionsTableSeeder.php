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
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 1,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 1,
                'created_at' => '2023-11-13 12:10:22',
                'updated_at' => '2023-11-13 12:45:26',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'US-P-2023-2024-Cd-2',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 2,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 1,
                'created_at' => '2023-11-13 12:11:36',
                'updated_at' => '2023-11-13 12:45:50',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'US-P-2023-2024-Cd-3',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 3,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-11-13 12:16:25',
                'updated_at' => '2023-11-13 12:16:25',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'US-P-2023-2024-Cd-4',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 4,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 1,
                'statut' => 0,
                'created_at' => '2023-11-13 12:19:04',
                'updated_at' => '2023-11-13 12:19:04',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'US-S-2023-2024-S-1',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 5,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 7,
                'statut' => 1,
                'created_at' => '2023-11-13 13:20:45',
                'updated_at' => '2023-11-13 13:24:45',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'US-S-2023-2024-S-2',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 6,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 7,
                'statut' => 1,
                'created_at' => '2023-11-13 13:22:13',
                'updated_at' => '2023-11-13 13:25:07',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'US-S-2023-2024-S-3',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 7,
                'cycle_filiere_id' => NULL,
                'annee_id' => 2,
                'niveau_id' => 7,
                'statut' => 1,
                'created_at' => '2023-11-13 13:24:20',
                'updated_at' => '2023-11-13 13:25:20',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'US--S-2023-2024-PA-A-1',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 8,
                'cycle_filiere_id' => 1,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-13 14:10:51',
                'updated_at' => '2023-11-13 14:10:51',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'US--S-2023-2024-PA-A-2',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 9,
                'cycle_filiere_id' => 1,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 1,
                'created_at' => '2023-11-13 14:12:18',
                'updated_at' => '2023-11-14 09:42:23',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'US--S-2023-2024-PA-A-3',
                'date_inscription' => '2023-11-13',
                'apprenant_id' => 10,
                'cycle_filiere_id' => 1,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-13 14:13:49',
                'updated_at' => '2023-11-13 14:13:49',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'US--S-2023-2024-PA-A-4',
                'date_inscription' => '2023-11-14',
                'apprenant_id' => 11,
                'cycle_filiere_id' => 1,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-14 10:33:37',
                'updated_at' => '2023-11-14 10:33:37',
            ),
            11 => 
            array (
                'id' => 14,
                'code' => 'US--S-2023-2024-PA-A-1',
                'date_inscription' => '2023-11-20',
                'apprenant_id' => 14,
                'cycle_filiere_id' => 7,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-20 11:23:31',
                'updated_at' => '2023-11-20 11:23:31',
            ),
            12 => 
            array (
                'id' => 15,
                'code' => 'US--S-2023-2024-PA-A-2',
                'date_inscription' => '2023-11-20',
                'apprenant_id' => 15,
                'cycle_filiere_id' => 7,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-20 11:32:13',
                'updated_at' => '2023-11-20 11:32:13',
            ),
            13 => 
            array (
                'id' => 16,
                'code' => 'US--S-2023-2024-PA-A-3',
                'date_inscription' => '2023-11-20',
                'apprenant_id' => 16,
                'cycle_filiere_id' => 7,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-20 11:32:57',
                'updated_at' => '2023-11-20 11:32:57',
            ),
            14 => 
            array (
                'id' => 17,
                'code' => 'US--S-2023-2024-PA-A-4',
                'date_inscription' => '2023-11-20',
                'apprenant_id' => 17,
                'cycle_filiere_id' => 7,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-20 11:33:45',
                'updated_at' => '2023-11-20 11:33:45',
            ),
            15 => 
            array (
                'id' => 18,
                'code' => 'US--S-2023-2024-PA-A-5',
                'date_inscription' => '2023-11-20',
                'apprenant_id' => 18,
                'cycle_filiere_id' => 7,
                'annee_id' => 2,
                'niveau_id' => 19,
                'statut' => 0,
                'created_at' => '2023-11-20 11:35:13',
                'updated_at' => '2023-11-20 11:35:13',
            ),
        ));
        
        
    }
}