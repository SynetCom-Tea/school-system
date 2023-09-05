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
        ]);
        Niveau::create([
            'code' => 'CP',
            'libelle' => 'Cours Preparatoire',
        ]);
        Niveau::create([
            'code' => 'CE1',
            'libelle' => 'Cours Elementaire 1',
        ]);
        Niveau::create([
            'code' => 'CE2',
            'libelle' => 'Cours Elementaire 2',
        ]);
        Niveau::create([
            'code' => 'CM1',
            'libelle' => 'Cours Moyen 1',
        ]);
        Niveau::create([
            'code' => 'CM2',
            'libelle' => 'Cours Moyen 2',
        ]);
        Niveau::create([
            'code' => '6e',
            'libelle' => 'Sixieme',
        ]);
        Niveau::create([
            'code' => '5e',
            'libelle' => 'Cinquieme',
        ]);
        Niveau::create([
            'code' => '4e',
            'libelle' => 'Quatrieme',
        ]);
        Niveau::create([
            'code' => '3e',
            'libelle' => 'Troisieme',
        ]);
        Niveau::create([
            'code' => '1A M',
            'libelle' => 'Premiere Année Moyen',
        ]);
        Niveau::create([
            'code' => '2A M',
            'libelle' => 'Deuxieme Année Moyen',
        ]);
        Niveau::create([
            'code' => '3A M',
            'libelle' => 'Troisieme Année Moyen',
        ]);
        Niveau::create([
            'code' => '2nd A',
            'libelle' => 'Seconde A',
        ]);
        Niveau::create([
            'code' => '2nd C',
            'libelle' => 'Seconde C',
        ]);
        Niveau::create([
            'code' => '1ere A',
            'libelle' => 'Premiere A',
        ]);
        Niveau::create([
            'code' => '1ere C',
            'libelle' => 'Premiere C',
        ]);
        Niveau::create([
            'code' => '1ere D',
            'libelle' => 'Premiere D',
        ]);
        Niveau::create([
            'code' => 'TA',
            'libelle' => 'Terminale A',
        ]);
        Niveau::create([
            'code' => 'TC',
            'libelle' => 'Terminale C',
        ]);
        Niveau::create([
            'code' => 'TD',
            'libelle' => 'Terminale D',
        ]);
        Niveau::create([
            'code' => '1A S',
            'libelle' => 'Prémiere Année',
        ]);
        Niveau::create([
            'code' => '2A S',
            'libelle' => 'Deuxieme Année',
        ]);
        Niveau::create([
            'code' => '3A S',
            'libelle' => 'Troisieme Année',
        ]);
        Niveau::create([
            'code' => '4A S',
            'libelle' => 'Quatrieme Année',
        ]);
    }
}
