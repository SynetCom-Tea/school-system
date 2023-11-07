<?php

namespace Database\Seeders;

use App\Models\Annee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Annee::create([
            'libelle' => '2022-2023',
        ]);
        Annee::create([
            'libelle' => '2023-2024',
            'actif'=>1
        ]);
    }
}
