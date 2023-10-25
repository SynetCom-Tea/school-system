<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classe::create([
            'id' => 1,
            'code' => 'CIA',
            'libelle' => 'CI A',
            'etablissement_section_id' => 1,
            'niveau_id' => 1
        ]);
        Classe::create([
            'id' => 2,
            'code' => 'CIB',
            'libelle' => 'CI B',
            'etablissement_section_id' => 1,
            'niveau_id' => 1
        ]);
        Classe::create([
            'id' => 3,
            'code' => 'CP',
            'libelle' => 'CP',
            'etablissement_section_id' => 1,
            'niveau_id' => 2
        ]);
        Classe::create([
            'id' => 4,
            'code' => 'CE1A',
            'libelle' => 'CE1 A',
            'etablissement_section_id' => 1,
            'niveau_id' => 3
        ]);
        // Classe::create([
        //     'id' => 4,
        //     'code' => 'CE1B',
        //     'libelle' => 'CE1 B',
        //     'etablissement_section_id' => 1,
        //     'niveau_id' => 3
        // ]);
        Classe::create([
            'id' => 5,
            'code' => 'CE2',
            'libelle' => 'CE2',
            'etablissement_section_id' => 1,
            'niveau_id' => 4
        ]);
        Classe::create([
            'id' => 6,
            'code' => 'CM1A',
            'libelle' => 'CM1 A',
            'etablissement_section_id' => 1,
            'niveau_id' => 5
        ]);
        Classe::create([
            'id' => 7,
            'code' => 'CM1B',
            'libelle' => 'CM1 B',
            'etablissement_section_id' => 1,
            'niveau_id' => 5
        ]);
        Classe::create([
            'id' => 8,
            'code' => 'CM2A',
            'libelle' => 'CM2 A',
            'etablissement_section_id' => 1,
            'niveau_id' => 6
        ]);
        Classe::create([
            'id' => 9,
            'code' => 'CM2B',
            'libelle' => 'CM2 B',
            'etablissement_section_id' => 1,
            'niveau_id' => 6
        ]);
        Classe::create([
            'id' => 10,
            'code' => '6eA',
            'libelle' => 'Sixième A',
            'etablissement_section_id' => 2,
            'niveau_id' => 7
        ]);
        Classe::create([
            'id' => 11,
            'code' => '6eB',
            'libelle' => 'Sixième B',
            'etablissement_section_id' => 2,
            'niveau_id' => 7
        ]);
        Classe::create([
            'id' => 12,
            'code' => '5eA',
            'libelle' => 'Cinquième A',
            'etablissement_section_id' => 2,
            'niveau_id' => 8
        ]);
        Classe::create([
            'id' => 13,
            'code' => '5eB',
            'libelle' => 'Cinquième B',
            'etablissement_section_id' => 2,
            'niveau_id' => 8
        ]);
        Classe::create([
            'id' => 14,
            'code' => '4e',
            'libelle' => 'Quatrième',
            'etablissement_section_id' => 2,
            'niveau_id' => 9
        ]);
        Classe::create([
            'id' => 15,
            'code' => '3eA',
            'libelle' => 'Troisième A',
            'etablissement_section_id' => 2,
            'niveau_id' => 10
        ]);
        Classe::create([
            'id' => 16,
            'code' => '3eB',
            'libelle' => 'Troisième B',
            'etablissement_section_id' => 2,
            'niveau_id' => 10
        ]);
        Classe::create([
            'id' => 17,
            'code' => '2ndeA',
            'libelle' => 'Seconde A',
            'etablissement_section_id' => 2,
            'niveau_id' => 11
        ]);
        Classe::create([
            'id' => 18,
            'code' => '2ndeC',
            'libelle' => 'Seconde C',
            'etablissement_section_id' => 2,
            'niveau_id' => 12
        ]);

        Classe::create([
            'id' => 19,
            'code' => '1èreA',
            'libelle' => 'Première A',
            'etablissement_section_id' => 2,
            'niveau_id' => 13
        ]);
        Classe::create([
            'id' => 20,
            'code' => '1èreC',
            'libelle' => 'Première C',
            'etablissement_section_id' => 2,
            'niveau_id' => 14
        ]);
        Classe::create([
            'id' => 21,
            'code' => '1èreD',
            'libelle' => 'Première D',
            'etablissement_section_id' => 2,
            'niveau_id' => 15
        ]);
        Classe::create([
            'id' => 22,
            'code' => 'TleA1',
            'libelle' => 'Terminale A1',
            'etablissement_section_id' => 2,
            'niveau_id' => 16
        ]);
        Classe::create([
            'id' => 23,
            'code' => 'Tle A2',
            'libelle' => 'Terminale A2',
            'etablissement_section_id' => 2,
            'niveau_id' => 16
        ]);
        Classe::create([
            'id' => 24,
            'code' => 'Tle C',
            'libelle' => 'Terminale C',
            'etablissement_section_id' => 2,
            'niveau_id' => 17
        ]);
        Classe::create([
            'id' => 25,
            'code' => 'Tle D',
            'libelle' => 'Terminale D',
            'etablissement_section_id' => 2,
            'niveau_id' => 18
        ]);
        Classe::create([
            'id' => 26,
            'code' => 'Group B',
            'libelle' => 'Group B',
            'etablissement_section_id' => 3,
            'niveau_id' => 22,
            'cycle_filiere_id'=>2
        ]);
        Classe::create([
            'id' => 27,
            'code' => 'Group A',
            'libelle' => 'Group A',
            'etablissement_section_id' => 4,
            'niveau_id' => 26,
            'cycle_filiere_id'=>3
        ]);
    }
}
