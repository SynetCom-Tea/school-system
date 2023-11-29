<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegimeValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('regime_validations')->delete();

        DB::table('regime_validations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'libelle' => 'Capitalisation',
                'description' => '',
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 11:48:14',
                'updated_at' => '2023-11-13 11:48:14',
            ),
            1 =>
            array (
                'id' => 2,
                'libelle' => 'Compensation Orienté',
            'description' => 'Le semestre peut être également acquis par compensation entres les différentes UE. La moyenne générale est calculée sur la base des moyennes obtenues aux UE composant le semestre pondéré par leurs coefficients respectifs.Le semestre est alors acquis si cette moyenne est égale ou supérieure à 10 et aussi la capitalisation d\'une somme des crédits ',
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
            2 =>
            array (
                'id' => 3,
                'libelle' => 'Compensation Ordinaire',
            'description' => 'Le semestre peut être également acquis par compensation entres les différentes UE. La moyenne générale est calculée sur la base des moyennes obtenues aux UE composant le semestre pondéré par leurs coefficients respectifs.Le semestre est alors acquis si cette moyenne est égale ou supérieure à 10 ',
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
        ));
    }
}
