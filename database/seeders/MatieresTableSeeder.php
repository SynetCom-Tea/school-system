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
            21 => 
            array (
                'nom' => 'Langage POO',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Langage POO',
            ),
            22 => 
            array (
                'nom' => 'Merise',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Merise',
            ),
            23 => 
            array (
                'nom' => 'RO',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/RO',
            ),
            24 => 
            array (
                'nom' => 'UML',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/UML',
            ),
            25 => 
            array (
                'nom' => 'Maths Financière',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Maths Financière',
            ),
            26 => 
            array (
                'nom' => 'Probabilité',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Probabilité',
            ),
            27 => 
            array (
                'nom' => 'Comptabilité',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Comptabilité',
            ),
            28 => 
            array (
                'nom' => 'RGH',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/RGH',
            ),
            29 => 
            array (
                'nom' => 'Statistique',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Statistique',
            ),
            30 => 
            array (
                'nom' => 'DB avancé',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/DB avancé',
            ),
            31 => 
            array (
                'nom' => 'Python avancé',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Python avancé',
            ),
            32 => 
            array (
                'nom' => 'Fondamentaux de maths de données',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Fondamentaux de maths de données',
            ),
            33 => 
            array (
                'nom' => 'Réseau',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseau',
            ),
            34 => 
            array (
                'nom' => 'IA',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/IA',
            ),
            35 => 
            array (
                'nom' => 'Réseau avancé',
                'etablissement_section_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseau avancé',
            ),
            36 => 
            array (
            'nom' => 'Systèmes d’exploitation (linux, Windows)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Systèmes d’exploitation (linux, Windows)',
            ),
            37 => 
            array (
                'nom' => 'Connaissances et protocole en réseaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Connaissances et protocole en réseaux',
            ),
            38 => 
            array (
                'nom' => 'PROGICIELS DE GESTION 1',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/PROGICIELS DE GESTION 1',
            ),
            39 => 
            array (
            'nom' => 'Systèmes d’information (Merise)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Systèmes d’information (Merise)',
            ),
            40 => 
            array (
            'nom' => 'Algorithmique et Programmation (Langage C)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Algorithmique et Programmation (Langage C)',
            ),
            41 => 
            array (
            'nom' => 'Recherche Opérationnelle 1 (Programmation linéaire et théorie des graphes)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Recherche Opérationnelle 1 (Programmation linéaire et théorie des graphes)',
            ),
            42 => 
            array (
                'nom' => 'ECONOMIE GENERALE',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/ECONOMIE GENERALE',
            ),
            43 => 
            array (
                'nom' => 'Mathématiques financières',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Mathématiques financières',
            ),
            44 => 
            array (
                'nom' => 'DROIT DU TRAVAIL',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/DROIT DU TRAVAIL',
            ),
            45 => 
            array (
                'nom' => 'DROIT DES AFFAIRES',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/DROIT DES AFFAIRES',
            ),
            46 => 
            array (
                'nom' => 'Fiscalité',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Fiscalité',
            ),
            47 => 
            array (
                'nom' => 'Anglais',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Anglais',
            ),
            48 => 
            array (
                'nom' => 'Réseaux locaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseaux locaux',
            ),
            49 => 
            array (
                'nom' => 'Réseau Internet',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Réseau Internet',
            ),
            50 => 
            array (
                'nom' => 'PROGICIELS DE GESTION 2',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/PROGICIELS DE GESTION 2',
            ),
            51 => 
            array (
                'nom' => 'Structure des données 1',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Structure des données 1',
            ),
            52 => 
            array (
            'nom' => 'Systèmes d’information (UML)',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            'code' => 'Supérieure/Systèmes d’information (UML)',
            ),
            53 => 
            array (
                'nom' => 'Gestion des projets',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Gestion des projets',
            ),
            54 => 
            array (
                'nom' => 'GESTION DES STOCKS',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/GESTION DES STOCKS',
            ),
            55 => 
            array (
                'nom' => 'LOGISTIQUE ET PRODUCTION',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/LOGISTIQUE ET PRODUCTION',
            ),
            56 => 
            array (
                'nom' => 'Administration réseaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Administration réseaux',
            ),
            57 => 
            array (
                'nom' => 'Sécurité réseaux',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Sécurité réseaux',
            ),
            58 => 
            array (
                'nom' => 'Structure des données 2',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Structure des données 2',
            ),
            59 => 
            array (
                'nom' => 'Programmation orientée objets',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Programmation orientée objets',
            ),
            60 => 
            array (
                'nom' => 'Base des données',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Base des données',
            ),
            61 => 
            array (
                'nom' => 'Recherche Opérationnelle 2',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/Recherche Opérationnelle 2',
            ),
            62 => 
            array (
                'nom' => 'ENTREPRENARIAT',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/ENTREPRENARIAT',
            ),
            63 => 
            array (
                'nom' => 'CONTROLE DE GESTION',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/CONTROLE DE GESTION',
            ),
            64 => 
            array (
                'nom' => 'AUDIT',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/AUDIT',
            ),
            65 => 
            array (
                'nom' => 'INGENIERIE FINANCIERE',
                'etablissement_section_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Supérieure/INGENIERIE FINANCIERE',
            ),
            66 => 
            array (
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