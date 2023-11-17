<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemeLmdsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('systeme_lmds')->delete();
        
        \DB::table('systeme_lmds')->insert(array (
            0 => 
            array (
                'id' => 1,
                'libelle' => 'Mixte',
            'description' => ': Il s’agit d’un régime d’évaluation qui regroupe les examens finaux (à raison de 70% de la note finale) ainsi que le contrôle continu (à raison de 30% de la note finale). La note du contrôle continu est scindée en devoirs surveillés et/ou travaux pratiqu',
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 11:48:14',
                'updated_at' => '2023-11-13 11:48:14',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'Controle continu',
            'description' => 'Ce régime d’évaluation repose exclusivement sur le contrôle continu (devoirs surveillés, tests oraux, présentations, travaux pratiques etc.). Le régime contrôle continu applique les taux de 80% pour les devoirs surveillés et 20% pour les autres modalités ',
                'deleted_at' => NULL,
                'created_at' => '2023-11-13 11:48:15',
                'updated_at' => '2023-11-13 11:48:15',
            ),
        ));
        
        
    }
}