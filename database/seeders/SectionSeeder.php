<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'libelle' => 'Première'
        ]);
        Section::create([
            'libelle' => 'Collège'
        ]);
        Section::create([
            'libelle' => 'Lycée'
        ]);
        Section::create([
            'libelle' => 'Superieur'
        ]);
    }
}
