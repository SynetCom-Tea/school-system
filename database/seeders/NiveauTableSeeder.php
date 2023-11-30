<?php

namespace Database\Seeders;

use Modules\Enseignement\Entities\Niveau;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Niveau::create([
            'code' => 'CI',
            'libelle' => 'Cours d\'initiation',
            'section_id' => 1,
        ]);
        Niveau::create([
            'code' => 'CP',
            'libelle' => 'Cours Preparatoire',
            'section_id' => 1,
        ]);
        Niveau::create([
            'code' => 'CE1',
            'libelle' => 'Cours Elementaire 1',
            'section_id' => 1,
        ]);
        Niveau::create([
            'code' => 'CE2',
            'libelle' => 'Cours Elementaire 2',
            'section_id' => 1,
        ]);
        Niveau::create([
            'code' => 'CM1',
            'libelle' => 'Cours Moyen 1',
            'section_id' => 1,
        ]);
        Niveau::create([
            'code' => 'CM2',
            'libelle' => 'Cours Moyen 2',
            'section_id' => 1,
        ]);
        Niveau::create([
            'code' => '6e',
            'libelle' => 'Sixieme',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '5e',
            'libelle' => 'Cinquieme',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '4e',
            'libelle' => 'Quatrieme',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '3e',
            'libelle' => 'Troisieme',
            'section_id' => 2,
        ]);

        Niveau::create([
            'code' => '2nd A',
            'libelle' => 'Seconde A',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '2nd C',
            'libelle' => 'Seconde C',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '1ere A',
            'libelle' => 'Premiere A',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '1ere C',
            'libelle' => 'Premiere C',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => '1ere D',
            'libelle' => 'Premiere D',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => 'TA',
            'libelle' => 'Terminale A',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => 'TC',
            'libelle' => 'Terminale C',
            'section_id' => 2,
        ]);
        Niveau::create([
            'code' => 'TD',
            'libelle' => 'Terminale D',
            'section_id' => 2,
        ]);
        // Niveau::create([
        //     'code' => '1A M',
        //     'libelle' => 'Premiere Année Moyen',
        //     'section_id' => 3,
        // ]);
        // Niveau::create([
        //     'code' => '2A M',
        //     'libelle' => 'Deuxieme Année Moyen',
        //     'section_id' => 3,
        // ]);
        // Niveau::create([
        //     'code' => '3A M',
        //     'libelle' => 'Troisieme Année Moyen',
        //     'section_id' => 3,
        // ]);
        Niveau::create([
            'code' => '1ère année',
            'libelle' => 'Prémiere Année',
            'section_id' => 3,
        ]);
        Niveau::create([
            'code' => '2e année',
            'libelle' => 'Deuxieme Année',
            'section_id' => 3,
        ]);
        Niveau::create([
            'code' => '3e année',
            'libelle' => 'Troisieme Année',
            'section_id' => 3,
        ]);
        Niveau::create([
            'code' => '4e année',
            'libelle' => 'Quatrieme Année',
            'section_id' => 3,
        ]);

        // Niveau::create([
        //     'code' => '1ère année',
        //     'libelle' => 'Prémiere Année',
        //     'section_id' => 4,
        // ]);
        // Niveau::create([
        //     'code' => '2e année',
        //     'libelle' => 'Deuxieme Année',
        //     'section_id' => 4,
        // ]);
        // Niveau::create([
        //     'code' => '3e année',
        //     'libelle' => 'Troisieme Année',
        //     'section_id' => 4,
        // ]);
        // Niveau::create([
        //     'code' => '4e année',
        //     'libelle' => 'Quatrieme Année',
        //     'section_id' => 4,
        // ]);
    }
}
