<?php

namespace Database\Seeders;

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
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Octobre', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Novembre', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Décembre', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Janvier', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Février', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Mars', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Avril', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Mai', 'statut' => 1]);
        Periode::create(['type' => 'Trimestre', 'libelle' => 'Juin', 'statut' => 1]);
    }
}
