<?php

namespace Database\Seeders;

use App\Models\ClasseAnnee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseAnneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClasseAnnee::create([

            'classe_id' => 4,
            'annee_id' => 2,
        ]);

        ClasseAnnee::create([
            'classe_id' => 9,
            'annee_id' => 2,
        ]);

        ClasseAnnee::create([
            'classe_id' => 12,
            'annee_id' => 2,
        ]);
        ClasseAnnee::create([

            'classe_id' => 16,
            'annee_id' => 2,
        ]);

        ClasseAnnee::create([
            'classe_id' => 17,
            'annee_id' => 2,
        ]);

        ClasseAnnee::create([
            'classe_id' => 25,
            'annee_id' => 2,
        ]);
        ClasseAnnee::create([
            'classe_id' => 8,
            'annee_id' => 2,
        ]);
    }
}
