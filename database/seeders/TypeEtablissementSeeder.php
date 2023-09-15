<?php

namespace Database\Seeders;

use App\Models\TypeEtablissement;
use App\Models\SystemeLmd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeEtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeEtablissement::create(['name' => 'Université']);
        TypeEtablissement::create(['name' => 'Ecole']);
        TypeEtablissement::create(['name' => 'Institut']);

        SystemeLmd::create(['libelle' => 'Mixte', 'description' => ': Il s’agit d’un régime d’évaluation qui regroupe les examens finaux (à raison de 70% de la note finale) ainsi que le contrôle continu (à raison de 30% de la note finale). La note du contrôle continu est scindée en devoirs surveillés et/ou travaux pratiques (20%) et d’exercices, de tests oraux, de présentations etc. (10%)']);
        SystemeLmd::create(['libelle' => 'Controle continu', 'description' => 'Ce régime d’évaluation repose exclusivement sur le contrôle continu (devoirs surveillés, tests oraux, présentations, travaux pratiques etc.). Le régime contrôle continu applique les taux de 80% pour les devoirs surveillés et 20% pour les autres modalités d’examen tels que les exercices, les travaux pratiques et les exposés']);
    }
}
