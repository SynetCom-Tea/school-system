<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NiveauMatieresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('niveau_matieres')->delete();
        
        \DB::table('niveau_matieres')->insert(array (
            0 => 
            array (
                'id' => 1,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Ecriture/CI',
            ),
            1 => 
            array (
                'id' => 2,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Ecriture/CP',
            ),
            2 => 
            array (
                'id' => 3,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '5',
                'niveau_id' => 3,
                'matiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Ecriture/CE1',
            ),
            3 => 
            array (
                'id' => 4,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '5',
                'niveau_id' => 4,
                'matiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Ecriture/CE2',
            ),
            4 => 
            array (
                'id' => 5,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '5',
                'niveau_id' => 5,
                'matiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Ecriture/CM1',
            ),
            5 => 
            array (
                'id' => 6,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '5',
                'niveau_id' => 6,
                'matiere_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Ecriture/CM2',
            ),
            6 => 
            array (
                'id' => 7,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Lecture/CI',
            ),
            7 => 
            array (
                'id' => 8,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Lecture/CP',
            ),
            8 => 
            array (
                'id' => 9,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 3,
                'matiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Lecture/CE1',
            ),
            9 => 
            array (
                'id' => 10,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 4,
                'matiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Lecture/CE2',
            ),
            10 => 
            array (
                'id' => 11,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 5,
                'matiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Lecture/CM1',
            ),
            11 => 
            array (
                'id' => 12,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 6,
                'matiere_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Lecture/CM2',
            ),
            12 => 
            array (
                'id' => 13,
                'volume_horaire' => '60',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Calcul/CI',
            ),
            13 => 
            array (
                'id' => 14,
                'volume_horaire' => '60',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Calcul/CP',
            ),
            14 => 
            array (
                'id' => 15,
                'volume_horaire' => '60',
                'coefficient' => '2',
                'notation' => '40',
                'niveau_id' => 3,
                'matiere_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Calcul/CE1',
            ),
            15 => 
            array (
                'id' => 16,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Récitation/CI',
            ),
            16 => 
            array (
                'id' => 17,
                'volume_horaire' => '50',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Récitation/CP',
            ),
            17 => 
            array (
                'id' => 18,
                'volume_horaire' => '30',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Chant/CI',
            ),
            18 => 
            array (
                'id' => 19,
                'volume_horaire' => '30',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Chant/CP',
            ),
            19 => 
            array (
                'id' => 20,
                'volume_horaire' => '30',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Dessin/CI',
            ),
            20 => 
            array (
                'id' => 21,
                'volume_horaire' => '30',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Dessin/CP',
            ),
            21 => 
            array (
                'id' => 22,
                'volume_horaire' => '30',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 1,
                'matiere_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Dictée des mots/CI',
            ),
            22 => 
            array (
                'id' => 23,
                'volume_horaire' => '30',
                'coefficient' => '2',
                'notation' => '10',
                'niveau_id' => 2,
                'matiere_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
                'code' => 'Dictée des mots/CP',
            ),
        ));
        
        
    }
}