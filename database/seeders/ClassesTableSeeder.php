<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClassesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('classes')->delete();
        
        \DB::table('classes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'CI A',
                'libelle' => 'Cours d\'initiation A',
                'etablissement_section_id' => 1,
                'niveau_id' => 1,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'CI B',
                'libelle' => 'Cours d\'initiation B',
                'etablissement_section_id' => 1,
                'niveau_id' => 1,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'CI C',
                'libelle' => 'Cours d\'initiation C',
                'etablissement_section_id' => 1,
                'niveau_id' => 1,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'CP A',
                'libelle' => 'Cours Preparatoire A',
                'etablissement_section_id' => 1,
                'niveau_id' => 2,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'CP B',
                'libelle' => 'Cours Preparatoire B',
                'etablissement_section_id' => 1,
                'niveau_id' => 2,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'CE1 A',
                'libelle' => 'Cours Elementaire 1 A',
                'etablissement_section_id' => 1,
                'niveau_id' => 3,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'CE1 B',
                'libelle' => 'Cours Elementaire 1 B',
                'etablissement_section_id' => 1,
                'niveau_id' => 3,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'CE2 A',
                'libelle' => 'Cours Elementaire 2 A',
                'etablissement_section_id' => 1,
                'niveau_id' => 4,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'CE2 B',
                'libelle' => 'Cours Elementaire 2 B',
                'etablissement_section_id' => 1,
                'niveau_id' => 4,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'CM1 A',
                'libelle' => 'Cours Moyen 1 A',
                'etablissement_section_id' => 1,
                'niveau_id' => 5,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'CM1 B',
                'libelle' => 'Cours Moyen 1 B',
                'etablissement_section_id' => 1,
                'niveau_id' => 5,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'CM1 C',
                'libelle' => 'Cours Moyen 1 C',
                'etablissement_section_id' => 1,
                'niveau_id' => 5,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'CM2 A',
                'libelle' => 'Cours Moyen 2 A',
                'etablissement_section_id' => 1,
                'niveau_id' => 6,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'CM2 B',
                'libelle' => 'Cours Moyen 2 B',
                'etablissement_section_id' => 1,
                'niveau_id' => 6,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '6e A',
                'libelle' => 'Sixieme A',
                'etablissement_section_id' => 2,
                'niveau_id' => 7,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '6e B',
                'libelle' => 'Sixieme B',
                'etablissement_section_id' => 2,
                'niveau_id' => 7,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '5e A',
                'libelle' => 'Cinquieme A',
                'etablissement_section_id' => 2,
                'niveau_id' => 8,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => '5e B',
                'libelle' => 'Cinquieme B',
                'etablissement_section_id' => 2,
                'niveau_id' => 8,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'TD 1',
                'libelle' => 'Terminale D 1',
                'etablissement_section_id' => 2,
                'niveau_id' => 18,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'Analyste Programmeur/1er cycle/ 1ère année',
                'libelle' => 'Analyste Programmeur/1er cycle/ Prémiere Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 19,
                'cycle_filiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'Analyste Programmeur/1er cycle/ 2e année',
                'libelle' => 'Analyste Programmeur/1er cycle/ Deuxieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 20,
                'cycle_filiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'Analyste Programmeur/1er cycle/ 3e année',
                'libelle' => 'Analyste Programmeur/1er cycle/ Troisieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 21,
                'cycle_filiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'Analyste Programmeur/1er cycle/ 4e année',
                'libelle' => 'Analyste Programmeur/1er cycle/ Quatrieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 22,
                'cycle_filiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'Analyste Programmeur/2e cycle/ 1ère année',
                'libelle' => 'Analyste Programmeur/2e cycle/ Prémiere Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 19,
                'cycle_filiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'Analyste Programmeur/2e cycle/ 2e année',
                'libelle' => 'Analyste Programmeur/2e cycle/ Deuxieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 20,
                'cycle_filiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'Informatique et Gestion/Cycle Moyen/ 1ère année',
                'libelle' => 'Informatique et Gestion/Cycle Moyen/ Prémiere Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 19,
                'cycle_filiere_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'Informatique et Gestion/Cycle Moyen/ 2e année',
                'libelle' => 'Informatique et Gestion/Cycle Moyen/ Deuxieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 20,
                'cycle_filiere_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'Informatique et Gestion/Cycle Moyen/ 3e année',
                'libelle' => 'Informatique et Gestion/Cycle Moyen/ Troisieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 21,
                'cycle_filiere_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'Informatique et Gestion/Cycle Moyen/ 4e année',
                'libelle' => 'Informatique et Gestion/Cycle Moyen/ Quatrieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 22,
                'cycle_filiere_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'Informatique et Gestion/1er cycle/ 1ère année',
                'libelle' => 'Informatique et Gestion/1er cycle/ Prémiere Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 19,
                'cycle_filiere_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'code' => 'Informatique et Gestion/1er cycle/ 2e année',
                'libelle' => 'Informatique et Gestion/1er cycle/ Deuxieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 20,
                'cycle_filiere_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'code' => 'Informatique et Gestion/1er cycle/ 3e année',
                'libelle' => 'Informatique et Gestion/1er cycle/ Troisieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 21,
                'cycle_filiere_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'code' => 'Gestion de projet/1er cycle/ 2e année',
                'libelle' => 'Gestion de projet/1er cycle/ Deuxieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 20,
                'cycle_filiere_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'code' => 'Gestion de projet/1er cycle/ 1ère année',
                'libelle' => 'Gestion de projet/1er cycle/ Prémiere Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 19,
                'cycle_filiere_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'code' => 'Gestion de projet/1er cycle/ 3e année',
                'libelle' => 'Gestion de projet/1er cycle/ Troisieme Année',
                'etablissement_section_id' => 3,
                'niveau_id' => 21,
                'cycle_filiere_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'code' => 'MIAGE/2e cycle/ 1ère année',
                'libelle' => 'MIAGE/2e cycle/ Prémiere Année',
                'etablissement_section_id' => 4,
                'niveau_id' => 19,
                'cycle_filiere_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'code' => 'MIAGE/2e cycle/ 2e année',
                'libelle' => 'MIAGE/2e cycle/ Deuxieme Année',
                'etablissement_section_id' => 4,
                'niveau_id' => 20,
                'cycle_filiere_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}