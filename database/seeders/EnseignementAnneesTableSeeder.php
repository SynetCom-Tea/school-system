<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnseignementAnneesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('enseignement_annees')->delete();
        
        \DB::table('enseignement_annees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'enseignant_id' => 1,
                'niveau_matiere_id' => 5,
                'classe_annee_id' => 1,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 12:04:29',
                'updated_at' => '2023-11-13 12:04:29',
                'deleted_at' => NULL,
                'code' => 'Cours d\'initiation A/Ecriture',
            ),
            1 => 
            array (
                'id' => 2,
                'enseignant_id' => 1,
                'niveau_matiere_id' => 16,
                'classe_annee_id' => 1,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 12:04:29',
                'updated_at' => '2023-11-13 12:04:29',
                'deleted_at' => NULL,
                'code' => 'Cours d\'initiation A/Calcul',
            ),
            2 => 
            array (
                'id' => 3,
                'enseignant_id' => 1,
                'niveau_matiere_id' => 40,
                'classe_annee_id' => 1,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 12:06:18',
                'updated_at' => '2023-11-13 12:06:18',
                'deleted_at' => NULL,
                'code' => 'Cours d\'initiation A/Chant',
            ),
            3 => 
            array (
                'id' => 4,
                'enseignant_id' => 2,
                'niveau_matiere_id' => 5,
                'classe_annee_id' => 2,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 12:07:55',
                'updated_at' => '2023-11-13 12:07:55',
                'deleted_at' => NULL,
                'code' => 'Cours d\'initiation B/Ecriture',
            ),
            4 => 
            array (
                'id' => 5,
                'enseignant_id' => 2,
                'niveau_matiere_id' => 16,
                'classe_annee_id' => 2,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 12:07:55',
                'updated_at' => '2023-11-13 12:07:55',
                'deleted_at' => NULL,
                'code' => 'Cours d\'initiation B/Calcul',
            ),
            5 => 
            array (
                'id' => 6,
                'enseignant_id' => 2,
                'niveau_matiere_id' => 40,
                'classe_annee_id' => 2,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 12:07:55',
                'updated_at' => '2023-11-13 12:07:55',
                'deleted_at' => NULL,
                'code' => 'Cours d\'initiation B/Chant',
            ),
            6 => 
            array (
                'id' => 7,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 41,
                'classe_annee_id' => 15,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:01',
                'updated_at' => '2023-11-13 13:14:01',
                'deleted_at' => NULL,
                'code' => 'Sixieme A/Maths',
            ),
            7 => 
            array (
                'id' => 8,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 44,
                'classe_annee_id' => 18,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:01',
                'updated_at' => '2023-11-13 13:14:01',
                'deleted_at' => NULL,
                'code' => 'Cinquieme B/Maths',
            ),
            8 => 
            array (
                'id' => 9,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 44,
                'classe_annee_id' => 17,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:01',
                'updated_at' => '2023-11-13 13:14:01',
                'deleted_at' => NULL,
                'code' => 'Cinquieme A/Maths',
            ),
            9 => 
            array (
                'id' => 10,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 51,
                'classe_annee_id' => 19,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:02',
                'updated_at' => '2023-11-13 13:14:02',
                'deleted_at' => NULL,
                'code' => 'Terminale D 1/Maths',
            ),
            10 => 
            array (
                'id' => 11,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 41,
                'classe_annee_id' => 16,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:02',
                'updated_at' => '2023-11-13 13:14:02',
                'deleted_at' => NULL,
                'code' => 'Sixieme B/Maths',
            ),
            11 => 
            array (
                'id' => 12,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 45,
                'classe_annee_id' => 15,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:02',
                'updated_at' => '2023-11-13 13:14:02',
                'deleted_at' => NULL,
                'code' => 'Sixieme A/PC',
            ),
            12 => 
            array (
                'id' => 13,
                'enseignant_id' => 3,
                'niveau_matiere_id' => 46,
                'classe_annee_id' => 17,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:14:02',
                'updated_at' => '2023-11-13 13:14:02',
                'deleted_at' => NULL,
                'code' => 'Cinquieme A/PC',
            ),
            13 => 
            array (
                'id' => 14,
                'enseignant_id' => 4,
                'niveau_matiere_id' => 55,
                'classe_annee_id' => 15,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:16:48',
                'updated_at' => '2023-11-13 13:16:48',
                'deleted_at' => NULL,
                'code' => 'Sixieme A/Histoire/Géo',
            ),
            14 => 
            array (
                'id' => 15,
                'enseignant_id' => 4,
                'niveau_matiere_id' => 55,
                'classe_annee_id' => 16,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:16:48',
                'updated_at' => '2023-11-13 13:16:48',
                'deleted_at' => NULL,
                'code' => 'Sixieme B/Histoire/Géo',
            ),
            15 => 
            array (
                'id' => 16,
                'enseignant_id' => 4,
                'niveau_matiere_id' => 56,
                'classe_annee_id' => 17,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:16:48',
                'updated_at' => '2023-11-13 13:16:48',
                'deleted_at' => NULL,
                'code' => 'Cinquieme A/Histoire/Géo',
            ),
            16 => 
            array (
                'id' => 17,
                'enseignant_id' => 4,
                'niveau_matiere_id' => 56,
                'classe_annee_id' => 18,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:16:48',
                'updated_at' => '2023-11-13 13:16:48',
                'deleted_at' => NULL,
                'code' => 'Cinquieme B/Histoire/Géo',
            ),
            17 => 
            array (
                'id' => 18,
                'enseignant_id' => 4,
                'niveau_matiere_id' => 64,
                'classe_annee_id' => 19,
                'filiere_niveau_matiere_ue_id' => NULL,
                'created_at' => '2023-11-13 13:16:48',
                'updated_at' => '2023-11-13 13:16:48',
                'deleted_at' => NULL,
                'code' => 'Terminale D 1/Histoire/Géo',
            ),
            18 => 
            array (
                'id' => 19,
                'enseignant_id' => 5,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 20,
                'filiere_niveau_matiere_ue_id' => 1,
                'created_at' => '2023-11-13 14:06:09',
                'updated_at' => '2023-11-13 14:06:09',
                'deleted_at' => NULL,
                'code' => 'Analyste Programmeur/Prémiere Année/1er cycle/Analyste Programmeur/1er cycle/ Prémiere Année/Langage POO',
            ),
            19 => 
            array (
                'id' => 20,
                'enseignant_id' => 5,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 20,
                'filiere_niveau_matiere_ue_id' => 2,
                'created_at' => '2023-11-13 14:06:09',
                'updated_at' => '2023-11-13 14:06:09',
                'deleted_at' => NULL,
                'code' => 'Analyste Programmeur/Prémiere Année/1er cycle/Analyste Programmeur/1er cycle/ Prémiere Année/Merise',
            ),
            20 => 
            array (
                'id' => 21,
                'enseignant_id' => 5,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 20,
                'filiere_niveau_matiere_ue_id' => 3,
                'created_at' => '2023-11-13 14:06:09',
                'updated_at' => '2023-11-13 14:06:09',
                'deleted_at' => NULL,
                'code' => 'Analyste Programmeur/Prémiere Année/1er cycle/Analyste Programmeur/1er cycle/ Prémiere Année/RO',
            ),
            21 => 
            array (
                'id' => 22,
                'enseignant_id' => 6,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 20,
                'filiere_niveau_matiere_ue_id' => 4,
                'created_at' => '2023-11-13 14:08:25',
                'updated_at' => '2023-11-13 14:08:25',
                'deleted_at' => NULL,
                'code' => 'Analyste Programmeur/Prémiere Année/1er cycle/Analyste Programmeur/1er cycle/ Prémiere Année/UML',
            ),
            22 => 
            array (
                'id' => 23,
                'enseignant_id' => 6,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 20,
                'filiere_niveau_matiere_ue_id' => 6,
                'created_at' => '2023-11-13 14:08:25',
                'updated_at' => '2023-11-13 14:08:25',
                'deleted_at' => NULL,
                'code' => 'Analyste Programmeur/Prémiere Année/1er cycle/Analyste Programmeur/1er cycle/ Prémiere Année/Probabilité',
            ),
            23 => 
            array (
                'id' => 24,
                'enseignant_id' => 6,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 20,
                'filiere_niveau_matiere_ue_id' => 5,
                'created_at' => '2023-11-13 14:08:25',
                'updated_at' => '2023-11-13 14:08:25',
                'deleted_at' => NULL,
                'code' => 'Analyste Programmeur/Prémiere Année/1er cycle/Analyste Programmeur/1er cycle/ Prémiere Année/Maths Financière',
            ),
            24 => 
            array (
                'id' => 25,
                'enseignant_id' => 7,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 8,
                'created_at' => '2023-11-20 10:13:12',
                'updated_at' => '2023-11-20 10:13:12',
                'deleted_at' => NULL,
            'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Systèmes d’exploitation (linux, Windows)',
            ),
            25 => 
            array (
                'id' => 26,
                'enseignant_id' => 7,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 9,
                'created_at' => '2023-11-20 10:13:12',
                'updated_at' => '2023-11-20 10:13:12',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Connaissances et protocole en réseaux',
            ),
            26 => 
            array (
                'id' => 27,
                'enseignant_id' => 8,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 10,
                'created_at' => '2023-11-20 10:15:16',
                'updated_at' => '2023-11-20 10:15:16',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/PROGICIELS DE GESTION 1',
            ),
            27 => 
            array (
                'id' => 28,
                'enseignant_id' => 8,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 11,
                'created_at' => '2023-11-20 10:15:16',
                'updated_at' => '2023-11-20 10:15:16',
                'deleted_at' => NULL,
            'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Systèmes d’information (Merise)',
            ),
            28 => 
            array (
                'id' => 29,
                'enseignant_id' => 8,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 24,
                'created_at' => '2023-11-20 10:15:16',
                'updated_at' => '2023-11-20 10:15:16',
                'deleted_at' => NULL,
            'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Systèmes d’information (UML)',
            ),
            29 => 
            array (
                'id' => 30,
                'enseignant_id' => 9,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 14,
                'created_at' => '2023-11-20 10:16:43',
                'updated_at' => '2023-11-20 10:16:43',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/ECONOMIE GENERALE',
            ),
            30 => 
            array (
                'id' => 31,
                'enseignant_id' => 9,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 15,
                'created_at' => '2023-11-20 10:16:43',
                'updated_at' => '2023-11-20 10:16:43',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Mathématiques financières',
            ),
            31 => 
            array (
                'id' => 32,
                'enseignant_id' => 10,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 12,
                'created_at' => '2023-11-20 10:19:11',
                'updated_at' => '2023-11-20 10:19:11',
                'deleted_at' => NULL,
            'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Algorithmique et Programmation (Langage C)',
            ),
            32 => 
            array (
                'id' => 33,
                'enseignant_id' => 10,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 23,
                'created_at' => '2023-11-20 10:19:11',
                'updated_at' => '2023-11-20 10:19:11',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Structure des données 1',
            ),
            33 => 
            array (
                'id' => 34,
                'enseignant_id' => 10,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 26,
                'created_at' => '2023-11-20 10:19:11',
                'updated_at' => '2023-11-20 10:19:11',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/GESTION DES STOCKS',
            ),
            34 => 
            array (
                'id' => 35,
                'enseignant_id' => 11,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 13,
                'created_at' => '2023-11-20 10:22:50',
                'updated_at' => '2023-11-20 10:22:50',
                'deleted_at' => NULL,
            'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Recherche Opérationnelle 1 (Programmation linéaire et théorie des graphes)',
            ),
            35 => 
            array (
                'id' => 38,
                'enseignant_id' => 12,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 16,
                'created_at' => '2023-11-20 10:24:06',
                'updated_at' => '2023-11-20 10:24:06',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/DROIT DU TRAVAIL',
            ),
            36 => 
            array (
                'id' => 39,
                'enseignant_id' => 12,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 17,
                'created_at' => '2023-11-20 10:24:06',
                'updated_at' => '2023-11-20 10:24:06',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/DROIT DES AFFAIRES',
            ),
            37 => 
            array (
                'id' => 40,
                'enseignant_id' => 12,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 18,
                'created_at' => '2023-11-20 10:24:06',
                'updated_at' => '2023-11-20 10:24:06',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Fiscalité',
            ),
            38 => 
            array (
                'id' => 41,
                'enseignant_id' => 11,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 19,
                'created_at' => '2023-11-20 10:36:04',
                'updated_at' => '2023-11-20 10:36:04',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Anglais',
            ),
            39 => 
            array (
                'id' => 42,
                'enseignant_id' => 11,
                'niveau_matiere_id' => NULL,
                'classe_annee_id' => 36,
                'filiere_niveau_matiere_ue_id' => 28,
                'created_at' => '2023-11-20 10:36:04',
                'updated_at' => '2023-11-20 10:36:04',
                'deleted_at' => NULL,
                'code' => 'MASTER METHODES INFORMATIQUES APPLIQUEES A LA GESTION DES ENTREPRISES/Prémiere Année/2e cycle/MIAGE/2e cycle/ Prémiere Année/Anglais',
            ),
        ));
        
        
    }
}