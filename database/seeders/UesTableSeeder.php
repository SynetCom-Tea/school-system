<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ues')->delete();
        
        \DB::table('ues')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'UE 101',
                'libelle' => 'UE 101',
                'etablissement_section_id' => 3,
                'created_at' => '2023-11-13 13:58:28',
                'updated_at' => '2023-11-13 13:58:28',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'UE 102',
                'libelle' => 'UE 102',
                'etablissement_section_id' => 3,
                'created_at' => '2023-11-13 13:58:28',
                'updated_at' => '2023-11-13 13:58:28',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'UE 103',
                'libelle' => 'UE 103',
                'etablissement_section_id' => 3,
                'created_at' => '2023-11-13 13:58:28',
                'updated_at' => '2023-11-13 13:58:28',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'ORT',
                'libelle' => 'Outils des Réseaux et Télécommunication',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'PG1',
                'libelle' => 'PROGICIELS DE GESTION 1',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            5 => 
            array (
                'id' => 6,
            'code' => 'SI(merise)',
            'libelle' => 'Systèmes d’information (Merise)',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            6 => 
            array (
                'id' => 7,
            'code' => 'A&P(Langage C)',
            'libelle' => 'Algorithmique et Programmation (Langage C)',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            7 => 
            array (
                'id' => 8,
            'code' => 'RO1(PLTG)',
            'libelle' => 'Recherche Opérationnelle 1 (Programmation linéaire et théorie des graphes)',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'EE',
                'libelle' => 'Environnement Economique',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'EJ',
                'libelle' => 'Environnement juridique',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'A1',
                'libelle' => 'Anglais 1',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'RT2',
                'libelle' => 'Réseaux et Télécommunication 2',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'PG2',
                'libelle' => 'PROGICIELS DE GESTION 2',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'SD1',
                'libelle' => 'Structure des données 1',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            14 => 
            array (
                'id' => 15,
            'code' => 'SI(UML)',
            'libelle' => 'Systèmes d’information (UML)',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'GGP',
                'libelle' => 'Gestion des projets',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'GS',
                'libelle' => 'GESTION DES STOCKS',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'L&P',
                'libelle' => 'LOGISTIQUE ET PRODUCTION',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'A2',
                'libelle' => 'Anglais 2',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:02:59',
                'updated_at' => '2023-11-20 10:02:59',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'R&TA',
                'libelle' => 'Réseaux et télécom Approfondie',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'SD2',
                'libelle' => 'Structure des données 2',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'POO',
                'libelle' => 'Programmation orientée objets',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'BD',
                'libelle' => 'Base des données',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'RO2',
                'libelle' => 'Recherche Opérationnelle 2',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'ENTR',
                'libelle' => 'ENTREPRENARIAT',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'CG',
                'libelle' => 'CONTROLE DE GESTION',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'AUDIT',
                'libelle' => 'AUDIT',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'IG',
                'libelle' => 'INGENIERIE FINANCIERE',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'A3',
                'libelle' => 'Anglais 3',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:17',
                'updated_at' => '2023-11-20 10:09:17',
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'S&M',
                'libelle' => 'STAGES ET MEMOIRES',
                'etablissement_section_id' => 4,
                'created_at' => '2023-11-20 10:09:18',
                'updated_at' => '2023-11-20 10:09:18',
            ),
        ));
        
        
    }
}