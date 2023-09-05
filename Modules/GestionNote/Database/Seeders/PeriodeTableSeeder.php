<?php

namespace Modules\GestionNote\Database\Seeders;

use Modules\GestionNote\Entities\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Periode::create(['type' => 'Semestre', 'libelle' => 'Semestre I', 'statut' => 1]);
        Periode::create(['type' => 'Semestre', 'libelle' => 'Semestre II', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Trimestre I', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Trimestre II', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Trimestre III', 'statut' => 1]);
    }
}
