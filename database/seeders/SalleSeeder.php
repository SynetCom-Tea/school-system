<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Salle::create([
            'code' => '0990',
            'libelle' => 'Salle 2',
            'etablissement_id' => 1
        ]);
        Salle::create([
            'code' => '0090',
            'libelle' => 'Salle informatique',
            'etablissement_id' => 1
        ]);
        Salle::create([
            'code' => '0009',
            'libelle' => 'Salle 1',
            'etablissement_id' => 1
        ]);
        Salle::create([
            'code' => '0180',
            'libelle' => 'Salle 3',
            'etablissement_id' => 1
        ]);
    }
}
