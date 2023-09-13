<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('etablissements')->delete();


        \DB::table('etablissements')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Etablmt All sections',
                'email' => 'etageneral@gmail.com',
                'adresse' => 'Plateau',
                'telephone' => '\"20142564A\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => 'boDema.png',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-06 11:11:35',
                'updated_at' => '2023-09-06 11:11:35',
            ),

            1 =>
            array(
                'id' => 2,
                'name' => 'IAI-Niger',
                'email' => 'iainiger@gmail.com',
                'adresse' => 'Plateau',
                'telephone' => '\"20142564A\"',
                'ville' => 'Niamey',
                'statut' => 0,
                'logo' => 'iai-logo.jpg',
                'type_etablissement_id' => 3,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-06 11:11:35',
                'updated_at' => '2023-09-06 11:11:35',
            ),
            2 =>

            array(
                'id' => 3,
                'name' => 'UAM',
                'email' => 'uamniger@gmail.com',
                'adresse' =>  'Harobanda',
                'telephone' => '\"96451232\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => 'uam-logo.jpg',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-07 13:17:12',
                'updated_at' => '2023-09-07 13:17:12',
            ),
            3 =>

            array(
                'id' => 4,
                'name' => 'IAT-Niger',
                'email' => 'iatniger@gmail.com',
                'adresse' => 'Francophonie',
                'telephone' => '\"21047862\"',
                'ville' => 'Niamey',
                'statut' => 0,
                'logo' => 'iat-logo.png',
                'type_etablissement_id' => 3,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-07 13:33:37',
                'updated_at' => '2023-09-07 13:33:37',
            ),
            4 =>

            array(
                'id' => 5,
                'name' => 'Gamma',
                'email' => 'gamma@niger.com',
                'adresse' => 'Yantala',
                'telephone' => '\"21045478\"',
                'ville' => 'Tahoua',
                'statut' => 1,
                'logo' => 'log.png',
                'type_etablissement_id' => 3,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-07 13:43:21',
                'updated_at' => '2023-09-07 13:43:21',
            ),
            5 =>

            array(
                'id' => 6,
                'name' => 'Université de Maradi',
                'email' => 'uddm@gmail.com',
                'adresse' => 'Maradi',
                'telephone' => '\"20145698\"',
                'ville' => 'Maradi',
                'statut' => 1,
                'logo' => 'uddm.jpg',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 08:49:59',
                'updated_at' => '2023-09-08 08:49:59',
            ),
            6 =>

            array(
                'id' => 7,
                'name' => 'Université de Dosso',
                'email' => 'udoniger@gmail.com',
                'adresse' => 'Dosso',
                'telephone' => '\"21045621\"',
                'ville' => 'Dosso',
                'statut' => 0,
                'logo' => 'udo.jpg',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 08:52:42',
                'updated_at' => '2023-09-08 08:52:42',
            ),
            7 =>

            array(
                'id' => 8,
                'name' => 'Université de Tillabéri',
                'email' => 'utiniger@gmail.com',
                'adresse' => 'Tillaberi',
                'telephone' => '\"21254586\"',
                'ville' => 'Tillaberi',
                'statut' => 0,
                'logo' => 'iai-logo.jpg',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 08:54:32',
                'updated_at' => '2023-09-08 08:54:32',
            ),
            8 =>

            array(
                'id' => 9,
                'name' => 'Université de Tahoua',
                'email' => 'utaniger@gmail.com',
                'adresse' => 'Tahoua',
                'telephone' => '\"21478569\"',
                'ville' => 'Tahoua',
                'statut' => 1,
                'logo' => 'uta.webp',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 08:56:07',
                'updated_at' => '2023-09-08 08:56:07',
            ),
            9 =>

            array(
                'id' => 10,
                'name' => 'Université d\'Agadez',
                'email' =>  'uazniger@gmail.com',
                'adresse' => 'Arlit',
                'telephone' => '\"21356847\"',
                'ville' => 'Agadez',
                'statut' => 1,
                'logo' => 'uaz).jpg',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 08:57:42',
                'updated_at' => '2023-09-08 08:57:42',
            ),
            10 =>

            array(
                'id' => 11,
                'name' => 'Université de Zinder',
                'email' => 'uzniger@gmail.com',
                'adresse' => 'Zinder',
                'telephone' => '\"21235846\"',
                'ville' =>  'Zinder',
                'statut' => 1,
                'logo' => 'uz.jpg',
                'type_etablissement_id' => 1,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:01:06',
                'updated_at' => '2023-09-08 09:01:06',
            ),
            11 =>

            array(
                'id' => 12,
                'name' => 'IPSP',
                'email' => 'ipsp@gmail.com',
                'adresse' => 'Niamey 2000',
                'telephone' => '\"21044588\"',
                'ville' => 'Niamey',
                'statut' => 0,
                'logo' => 'ipsp.png',
                'type_etablissement_id' => 3,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:03:01',
                'updated_at' => '2023-09-08 09:03:01',
            ),
            12 =>


            array(
                'id' => 13,
                'name' => 'IFTIC',
                'email' => 'ifticne@gmail.com',
                'adresse' => 'Plateau',
                'telephone' => '\"21258468\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => 'iftic.png',
                'type_etablissement_id' => 3,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:11:44',
                'updated_at' => '2023-09-08 09:11:44',
            ),
            13 =>


            array(
                'id' => 14,
                'name' =>  'Collège-Lycée Mariama',
                'email' => 'clmariama@gmail.com',
                'adresse' => 'Nouveau Marché',
                'telephone' => '\"20548765\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => 'mariama.jpg',
                'type_etablissement_id' => 2,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:15:20',
                'updated_at' => '2023-09-08 09:15:20',
            ),
            14 =>


            array(
                'id' => 15,
                'name' =>  'INIME',
                'email' => 'inime@gmail.com',
                'adresse' => 'Francophonie',
                'telephone' => '\"21035647\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => 'inime.jpg',
                'type_etablissement_id' => 3,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:17:26',
                'updated_at' => '2023-09-08 09:17:26',
            ),
            15 =>

            array(
                'id' => 16,
                'name' =>  'CSP Lumière',
                'email' => 'lumiere@gmail.com',
                'adresse' =>  'Kalley-Sud',
                'telephone' => '\"96541235\"',
                'ville' => 'Niamey',
                'statut' => 0,
                'logo' =>  'lumiere.jpg',
                'type_etablissement_id' => 2,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:19:59',
                'updated_at' => '2023-09-08 09:19:59',
            ),
            16 =>


            array(
                'id' => 17,
                'name' => 'Lycée d\'Excellence',
                'email' => 'lexni@gmail.com',
                'adresse' => 'Bassora',
                'telephone' => '\"93521436\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' => 'lex.jpg',
                'type_etablissement_id' => 2,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:22:18',
                'updated_at' => '2023-09-08 09:22:18',
            ),

            17 =>
            array(
                'id' => 18,
                'name' => 'La Relève',
                'email' => 'releve@gmail.com',
                'adresse' => 'Koira Kano',
                'telephone' => '\"88521469\"',
                'ville' => 'Niamey',
                'statut' => 1,
                'logo' =>  'releve.jpg',
                'type_etablissement_id' => 2,
                'systeme_lmd_id' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 09:24:31',
                'updated_at' => '2023-09-08 09:24:31',
            ),
        ));
    }
}


//    public function run(): void
//     {
//         \DB::table('etablissements')->delete();

//         \DB::table('etablissements')->insert(array (
//             0 =>
//             array (
//                 'id' => 1,
//                 'name' => 'CSP Algoza',
//                 'email' => 'uin@gmail.com',
//                 'adresse' => 'Recassement',
//                 'telephone' => '["90099012", "89999000", "90099002"]',
//                 'ville' => 'Niamey',
//                 'type_etablissement_id' => 1,
//                 'deleted_at' => NULL,
//                 'created_at' => '2023-06-21 08:03:11',
//                 'updated_at' => '2023-06-21 08:03:11',
//             ),
//             1 =>
//             array (
//                 'id' => 2,
//                 'name' => 'Université Abdou Moumouni',
//                 'email' => 'uam@gmail.com',
//                 'adresse' => 'HBD',
//                 'telephone' => '["96898990", "92231223", "90123456"]',
//                 'ville' => 'Niamey',
//                 'type_etablissement_id' => 1,
//                 'deleted_at' => NULL,
//                 'created_at' => '2023-06-21 08:05:39',
//                 'updated_at' => '2023-06-21 08:05:39',
//             ),
//             2 =>
//             array (
//                 'id' => 3,
//                 'name' => 'IAI-Niger',
//                 'email' => 'iai@gmail.com',
//                 'adresse' => 'Plateau',
//                 'telephone' => '["89909000", "89900090", "88787878"]',
//                 'ville' => 'Niamey',
//                 'type_etablissement_id' => 2,
//                 'deleted_at' => NULL,
//                 'created_at' => '2023-06-21 08:08:02',
//                 'updated_at' => '2023-06-21 08:08:02',
//             ),
//         ));
//     }