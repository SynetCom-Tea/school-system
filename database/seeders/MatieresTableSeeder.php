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
                'nom' => 'Ecriture',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Ecriture',
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'Lecture',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Lecture',
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'Math',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Math',
            ),
            3 => 
            array (
                'id' => 4,
                'nom' => 'Dessin',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Dessin',
            ),
            4 => 
            array (
                'id' => 5,
                'nom' => 'Moral',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Moral',
            ),
            5 => 
            array (
                'id' => 7,
                'nom' => 'ICM',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/ICM',
            ),
            6 => 
            array (
                'id' => 8,
                'nom' => 'Etude de texte',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Etude de texte',
            ),
            7 => 
            array (
                'id' => 9,
                'nom' => 'Etude du milieu',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Etude du milieu',
            ),
            8 => 
            array (
                'id' => 10,
                'nom' => 'Anglais',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Anglais',
            ),
            9 => 
            array (
                'id' => 11,
                'nom' => 'Informatique',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Informatique',
            ),
            10 => 
            array (
                'id' => 12,
                'nom' => 'Chant',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Chant',
            ),
            11 => 
            array (
                'id' => 13,
                'nom' => 'Récitation',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Récitation',
            ),
            12 => 
            array (
                'id' => 14,
                'nom' => 'Calcul',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Calcul',
            ),
            13 => 
            array (
                'id' => 15,
                'nom' => 'Dictée des mots',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Dictée des mots',
            ),
            14 => 
            array (
                'id' => 16,
                'nom' => 'Rédaction',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Rédaction',
            ),
            15 => 
            array (
                'id' => 17,
                'nom' => 'Dictée question',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Dictée question',
            ),
            16 => 
            array (
                'id' => 18,
                'nom' => 'Histoire',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Histoire',
            ),
            17 => 
            array (
                'id' => 19,
                'nom' => 'Géographie',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Géographie',
            ),
            18 => 
            array (
                'id' => 20,
                'nom' => 'Mathématiques',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Mathématiques',
            ),
            19 => 
            array (
                'id' => 21,
                'nom' => 'Physique-Chimie',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Physique-Chimie',
            ),
            20 => 
            array (
                'id' => 22,
                'nom' => 'S.V.T',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/S.V.T',
            ),
            21 => 
            array (
                'id' => 23,
                'nom' => 'Économie Familiale',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Économie Familiale',
            ),
            22 => 
            array (
                'id' => 24,
                'nom' => 'Éducation Physique',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Éducation Physique',
            ),
            23 => 
            array (
                'id' => 25,
                'nom' => 'Conduite',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Conduite',
            ),
            24 => 
            array (
                'id' => 26,
                'nom' => 'Français',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Français',
            ),
            25 => 
            array (
                'id' => 27,
                'nom' => 'Histoire-géographie',
                'etablissement_section_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Secondaire/Histoire-géographie',
            ),
            26 => 
            array (
                'id' => 28,
                'nom' => 'Questions',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Questions',
            ),
            27 => 
            array (
                'id' => 29,
                'nom' => 'Copie',
                'etablissement_section_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Primaire/Copie',
            ),
        ));
        
        
    }
}