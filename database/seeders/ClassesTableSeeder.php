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
                'code' => 'CIA',
                'libelle' => 'CI A',
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
                'code' => 'CIB',
                'libelle' => 'CI B',
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
                'code' => 'CPA',
                'libelle' => 'CP A',
                'etablissement_section_id' => 1,
                'niveau_id' => 2,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'CPB',
                'libelle' => 'CP B',
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
                'code' => 'CE1',
                'libelle' => 'CE1',
                'etablissement_section_id' => 1,
                'niveau_id' => 3,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'CE2',
                'libelle' => 'CE2',
                'etablissement_section_id' => 1,
                'niveau_id' => 4,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'CM1',
                'libelle' => 'CM1',
                'etablissement_section_id' => 1,
                'niveau_id' => 5,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'CM2',
                'libelle' => 'CM2',
                'etablissement_section_id' => 1,
                'niveau_id' => 6,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'c',
                'libelle' => 'cv',
                'etablissement_section_id' => 1,
                'niveau_id' => 1,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'CI A',
                'libelle' => 'CI A',
                'etablissement_section_id' => 1,
                'niveau_id' => 1,
                'cycle_filiere_id' => NULL,
                'created_at' => '2023-10-28 07:30:11',
                'updated_at' => '2023-10-28 07:30:11',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '6 eme',
                'libelle' => '6 eme',
                'etablissement_section_id' => 2,
                'niveau_id' => 7,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '5 eme',
                'libelle' => '5 eme',
                'etablissement_section_id' => 2,
                'niveau_id' => 8,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '4 eme',
                'libelle' => '4 eme',
                'etablissement_section_id' => 2,
                'niveau_id' => 9,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '3 eme',
                'libelle' => '3 eme',
                'etablissement_section_id' => 2,
                'niveau_id' => 10,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'Seconde A',
                'libelle' => 'Seconde A',
                'etablissement_section_id' => 2,
                'niveau_id' => 11,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'Seconde C',
                'libelle' => 'Seconde C',
                'etablissement_section_id' => 2,
                'niveau_id' => 12,
                'cycle_filiere_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}