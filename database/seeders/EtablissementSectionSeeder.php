<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtablissementSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('section_etablissements')->delete();

        \DB::table('section_etablissements')->insert(array (
            0 =>
            array (
                'etablissement_id' => 1,
                'section_id' => 1,
            ),
            1 =>
            array (
                'etablissement_id' => 1,
                'section_id' => 2,
            ),
            2 =>
            array (
                'etablissement_id' => 1,
                'section_id' => 3,
            ),
        ));
    }
}
