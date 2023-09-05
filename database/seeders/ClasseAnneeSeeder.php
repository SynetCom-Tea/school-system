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

            'classe_id' => 1,
            'annee_id' => 1,
        ]);

        ClasseAnnee::create([
            'classe_id' => 2,
            'annee_id' => 1,
        ]);

        ClasseAnnee::create([
            'classe_id' => 3,
            'annee_id' => 1,
        ]);
    }
}
