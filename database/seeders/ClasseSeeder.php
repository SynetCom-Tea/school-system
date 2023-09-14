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
            'code' => '6e A',
            'libelle' => 'Sixieme A',
            'etablissement_section_id' => 2,
            'niveau_id' => 7
        ]);
        Classe::create([
            'code' => '6e B',
            'libelle' => 'Sixieme B',
            'etablissement_section_id' => 2,
            'niveau_id' => 7
        ]);
        Classe::create([
            'code' => '3e A',
            'libelle' => 'Troisieme A',
            'etablissement_section_id' => 2,
            'niveau_id' => 10
        ]);
    }
}
