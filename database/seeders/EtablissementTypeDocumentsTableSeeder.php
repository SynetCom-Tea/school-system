<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EtablissementTypeDocumentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('etablissement_type_documents')->delete();
        
        \DB::table('etablissement_type_documents')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type_document_id' => 1,
                'etablissement_section_id' => 1,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 11:51:50',
                'updated_at' => '2023-11-13 11:51:50',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type_document_id' => 2,
                'etablissement_section_id' => 1,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 11:51:50',
                'updated_at' => '2023-11-13 11:51:50',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'type_document_id' => 1,
                'etablissement_section_id' => 2,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 12:56:46',
                'updated_at' => '2023-11-13 12:56:46',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'type_document_id' => 2,
                'etablissement_section_id' => 2,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 12:56:46',
                'updated_at' => '2023-11-13 12:56:46',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'type_document_id' => 3,
                'etablissement_section_id' => 2,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 12:56:46',
                'updated_at' => '2023-11-13 12:56:46',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'type_document_id' => 1,
                'etablissement_section_id' => 3,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 13:42:27',
                'updated_at' => '2023-11-13 13:42:27',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'type_document_id' => 2,
                'etablissement_section_id' => 3,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 13:42:27',
                'updated_at' => '2023-11-13 13:42:27',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'type_document_id' => 3,
                'etablissement_section_id' => 3,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 13:42:27',
                'updated_at' => '2023-11-13 13:42:27',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'type_document_id' => 4,
                'etablissement_section_id' => 3,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 13:42:27',
                'updated_at' => '2023-11-13 13:42:27',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'type_document_id' => 5,
                'etablissement_section_id' => 3,
                'obligatoire' => 0,
                'statut' => '1',
                'created_at' => '2023-11-13 13:42:27',
                'updated_at' => '2023-11-13 13:42:27',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}