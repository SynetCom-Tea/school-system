<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //     J'ai eu du mal avec le type Json de téléphone. j'ai donc modifier le type en string après la migration. Voir la requete ci-dessous:

    //     ALTER TABLE etablissements
    // modify telephone varchar(255) default null

    public function run(): void
    {
        \DB::table('etablissement_sections')->delete();

        \DB::table('etablissement_sections')->insert(array(
            0 =>
            array(
                'id' => 1,
                'etablissement_id' => 1,
                'code' => NULL,
                'section_id' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'etablissement_id' => 2,
                'code' => NULL,
                'section_id' => 3,
            ),
            2 =>

            array(
                'id' => 3,
                'etablissement_id' => 3,
                'code' => NULL,
                'section_id' => 3,
            ),
            3 =>

            array(
                'id' => 4,
                'etablissement_id' => 4,
                'code' => NULL,
                'section_id' => 3,
            ),
            4 =>

            array(
                'id' => 5,
                'etablissement_id' => 4,
                'code' => NULL,
                'section_id' => 3,
            ),
            5 =>

            array(
                'id' => 6,
                'etablissement_id' => 5,
                'code' => NULL,
                'section_id' => 3,
            ),
            6 =>

            array(
                'id' => 7,
                'etablissement_id' => 6,
                'code' => NULL,
                'section_id' => 3,
            ),
            // 7 =>

            // array(
            //     'id' => 8,
            //     'etablissement_id' => 7,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 8 =>


            // array(
            //     'id' => 9,
            //     'etablissement_id' => 8,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 9 =>


            // array(
            //     'id' => 10,
            //     'etablissement_id' => 9,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 10 =>
            // array(
            //     'id' => 11,
            //     'etablissement_id' => 10,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 11 => array(
            //     'id' => 12,
            //     'etablissement_id' => 11,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 12 =>

            // array(
            //     'id' => 13,
            //     'etablissement_id' => 12,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 13 =>


            // array(
            //     'id' => 14,
            //     'etablissement_id' => 13,
            //     'code' => NULL,
            //     'section_id' => 2,
            // ),

            // 14 =>
            // array(
            //     'id' => 15,
            //     'etablissement_id' => 14,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),


            // 15 =>
            // array(
            //     'id' => 16,
            //     'etablissement_id' => 15,
            //     'code' => NULL,
            //     'section_id' => 1,
            // ),


            // 16 =>
            // array(
            //     'id' => 17,
            //     'etablissement_id' => 15,
            //     'code' => NULL,
            //     'section_id' => 2,
            // ),


            // 17 =>
            // array(
            //     'id' => 18,
            //     'etablissement_id' => 16,
            //     'code' => NULL,
            //     'section_id' => 2,
            // ),


            // 18 =>
            // array(
            //     'id' => 19,
            //     'etablissement_id' => 17,
            //     'code' => NULL,
            //     'section_id' => 1,
            // ),
            // 19 =>
            // array(
            //     'id' => 20,
            //     'etablissement_id' => 17,
            //     'code' => NULL,
            //     'section_id' => 2,
            // ),
            // 20 =>
            // array(
            //     'id' => 21,
            //     'etablissement_id' => 1,
            //     'code' => NULL,
            //     'section_id' => 2,
            // ),
            // 21 =>
            // array(
            //     'id' => 22,
            //     'etablissement_id' => 1,
            //     'code' => NULL,
            //     'section_id' => 3,
            // ),
            // 22 =>
            // array(
            //     'id' => 23,
            //     'etablissement_id' => 1,
            //     'code' => NULL,
            //     'section_id' => 4,
            // ),
        ));

    }
    // public function run(): void
    // {
    //     \DB::table('etablissement_section')->delete();

    //     \DB::table('etablissement_section')->insert(array (
    //         0 =>
    //         array (
    //             'etablissement_id' => 1,
    //             'section_id' => 1,
    //         ),
    //         1 =>
    //         array (
    //             'etablissement_id' => 1,
    //             'section_id' => 2,
    //         ),
    //         2 =>
    //         array (
    //             'etablissement_id' => 1,
    //             'section_id' => 3,
    //         ),
    //         3 =>
    //         array (
    //             'etablissement_id' => 1,
    //             'section_id' => 4,
    //         ),
    //     ));
    // }
}
