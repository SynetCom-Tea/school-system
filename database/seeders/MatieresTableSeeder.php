<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MatieresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('matieres')->delete();
        
        \DB::table('matieres')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'Dictée',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Dictée',
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'Ecriture',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Ecriture',
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'Lecture',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Lecture',
            ),
            3 => 
            array (
                'id' => 4,
                'nom' => 'Calcul',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Calcul',
            ),
            4 => 
            array (
                'id' => 5,
                'nom' => 'Etude de texte',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Etude de texte',
            ),
            5 => 
            array (
                'id' => 6,
                'nom' => 'Etude du milieu',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Etude du milieu',
            ),
            6 => 
            array (
                'id' => 7,
                'nom' => 'Chant',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Chant',
            ),
            7 => 
            array (
                'id' => 8,
                'nom' => 'Récitation',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Récitation',
            ),
            8 => 
            array (
                'id' => 9,
                'nom' => 'Maths',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Maths',
            ),
            9 => 
            array (
                'id' => 10,
                'nom' => 'PC',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/PC',
            ),
            10 => 
            array (
                'id' => 11,
                'nom' => 'Histoire/Géo',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Histoire/Géo',
            ),
            11 => 
            array (
                'id' => 12,
                'nom' => 'Anglais',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Anglais',
            ),
            12 => 
            array (
                'id' => 13,
                'nom' => 'EFS',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/EFS',
            ),
            13 => 
            array (
                'id' => 14,
                'nom' => 'Philo',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Philo',
            ),
            14 => 
            array (
                'id' => 15,
                'nom' => 'Arabe',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Arabe',
            ),
            15 => 
            array (
                'id' => 16,
                'nom' => 'SVT',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/SVT',
            ),
            16 => 
            array (
                'id' => 17,
                'nom' => 'EPS',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/EPS',
            ),
            17 => 
            array (
                'id' => 18,
                'nom' => 'Espagnol',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Espagnol',
            ),
            18 => 
            array (
                'id' => 19,
                'nom' => 'Informatique',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Informatique',
            ),
            19 => 
            array (
                'id' => 20,
                'nom' => 'Français',
                'etablissement_section_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Français',
            ),
            20 => 
            array (
                'id' => 21,
                'nom' => 'Français',
                'etablissement_section_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Français',
            ),
            21 => 
            array (
                'id' => 22,
                'nom' => 'Langage POO',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Langage POO',
            ),
            22 => 
            array (
                'id' => 23,
                'nom' => 'Merise',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Merise',
            ),
            23 => 
            array (
                'id' => 24,
                'nom' => 'RO',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/RO',
            ),
            24 => 
            array (
                'id' => 25,
                'nom' => 'UML',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/UML',
            ),
            25 => 
            array (
                'id' => 26,
                'nom' => 'Maths Financière',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Maths Financière',
            ),
            26 => 
            array (
                'id' => 27,
                'nom' => 'Probabilité',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Probabilité',
            ),
            27 => 
            array (
                'id' => 28,
                'nom' => 'Comptabilité',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Comptabilité',
            ),
            28 => 
            array (
                'id' => 29,
                'nom' => 'RGH',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/RGH',
            ),
            29 => 
            array (
                'id' => 30,
                'nom' => 'Statistique',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Statistique',
            ),
            30 => 
            array (
                'id' => 31,
                'nom' => 'DB avancé',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/DB avancé',
            ),
            31 => 
            array (
                'id' => 32,
                'nom' => 'Python avancé',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Python avancé',
            ),
            32 => 
            array (
                'id' => 33,
                'nom' => 'Fondamentaux de maths de données',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Fondamentaux de maths de données',
            ),
            33 => 
            array (
                'id' => 34,
                'nom' => 'Réseau',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseau',
            ),
            34 => 
            array (
                'id' => 35,
                'nom' => 'IA',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/IA',
            ),
            35 => 
            array (
                'id' => 36,
                'nom' => 'Réseau avancé',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseau avancé',
            ),
            36 => 
            array (
                'id' => 37,
            'nom' => 'Systèmes d’exploitation (linux, Windows)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Systèmes d’exploitation (linux, Windows)',
            ),
            37 => 
            array (
                'id' => 38,
                'nom' => 'Connaissances et protocole en réseaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Connaissances et protocole en réseaux',
            ),
            38 => 
            array (
                'id' => 39,
                'nom' => 'PROGICIELS DE GESTION 1',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/PROGICIELS DE GESTION 1',
            ),
            39 => 
            array (
                'id' => 40,
            'nom' => 'Systèmes d’information (Merise)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Systèmes d’information (Merise)',
            ),
            40 => 
            array (
                'id' => 41,
            'nom' => 'Algorithmique et Programmation (Langage C)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Algorithmique et Programmation (Langage C)',
            ),
            41 => 
            array (
                'id' => 42,
            'nom' => 'Recherche Opérationnelle 1 (Programmation linéaire et théorie des graphes)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Recherche Opérationnelle 1 (Programmation linéaire et théorie des graphes)',
            ),
            42 => 
            array (
                'id' => 43,
                'nom' => 'ECONOMIE GENERALE',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/ECONOMIE GENERALE',
            ),
            43 => 
            array (
                'id' => 44,
                'nom' => 'Mathématiques financières',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Mathématiques financières',
            ),
            44 => 
            array (
                'id' => 45,
                'nom' => 'DROIT DU TRAVAIL',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/DROIT DU TRAVAIL',
            ),
            45 => 
            array (
                'id' => 46,
                'nom' => 'DROIT DES AFFAIRES',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/DROIT DES AFFAIRES',
            ),
            46 => 
            array (
                'id' => 47,
                'nom' => 'Fiscalité',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Fiscalité',
            ),
            47 => 
            array (
                'id' => 48,
                'nom' => 'Anglais',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Anglais',
            ),
            48 => 
            array (
                'id' => 49,
                'nom' => 'Réseaux locaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseaux locaux',
            ),
            49 => 
            array (
                'id' => 50,
                'nom' => 'Réseau Internet',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseau Internet',
            ),
            50 => 
            array (
                'id' => 51,
                'nom' => 'PROGICIELS DE GESTION 2',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/PROGICIELS DE GESTION 2',
            ),
            51 => 
            array (
                'id' => 52,
                'nom' => 'Structure des données 1',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Structure des données 1',
            ),
            52 => 
            array (
                'id' => 53,
            'nom' => 'Systèmes d’information (UML)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Systèmes d’information (UML)',
            ),
            53 => 
            array (
                'id' => 54,
                'nom' => 'Gestion des projets',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Gestion des projets',
            ),
            54 => 
            array (
                'id' => 55,
                'nom' => 'GESTION DES STOCKS',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/GESTION DES STOCKS',
            ),
            55 => 
            array (
                'id' => 56,
                'nom' => 'LOGISTIQUE ET PRODUCTION',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/LOGISTIQUE ET PRODUCTION',
            ),
            56 => 
            array (
                'id' => 57,
                'nom' => 'Administration réseaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Administration réseaux',
            ),
            57 => 
            array (
                'id' => 58,
                'nom' => 'Sécurité réseaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Sécurité réseaux',
            ),
            58 => 
            array (
                'id' => 59,
                'nom' => 'Structure des données 2',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Structure des données 2',
            ),
            59 => 
            array (
                'id' => 60,
                'nom' => 'Programmation orientée objets',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Programmation orientée objets',
            ),
            60 => 
            array (
                'id' => 61,
                'nom' => 'Base des données',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Base des données',
            ),
            61 => 
            array (
                'id' => 62,
                'nom' => 'Recherche Opérationnelle 2',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Recherche Opérationnelle 2',
            ),
            62 => 
            array (
                'id' => 63,
                'nom' => 'ENTREPRENARIAT',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/ENTREPRENARIAT',
            ),
            63 => 
            array (
                'id' => 64,
                'nom' => 'CONTROLE DE GESTION',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/CONTROLE DE GESTION',
            ),
            64 => 
            array (
                'id' => 65,
                'nom' => 'AUDIT',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/AUDIT',
            ),
            65 => 
            array (
                'id' => 66,
                'nom' => 'INGENIERIE FINANCIERE',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/INGENIERIE FINANCIERE',
            ),
            66 => 
            array (
                'id' => 67,
                'nom' => 'STAGES ET MEMOIRES',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/STAGES ET MEMOIRES',
            ),
        ));
        
        
    }
}