<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Scolarite\Entities\Frais;

class FraisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //Frais d'inscription Primaire
        Frais::create([
            'id' => 1,
            'type_frais_id' => 1,
            // 'libelle' => 'Frais d\'inscription',
            'montant' => 10000,
            'annee_id' => 2,
            'etablissement_id' => 1,
            'niveau_id' => 1,
        ]);
        Frais::create([
            'id' => 2,
            // 'libelle' => 'Frais d\'inscription',
            'type_frais_id' => 1,
            'montant' => 10000,
            'niveau_id' => 2,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 3,
            // 'libelle' => 'Frais d\'inscription',
            'type_frais_id' => 1,
            'montant' => 10000,
            'niveau_id' => 3,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 4,
            'type_frais_id' => 1,
            'montant' => 10000,
            'niveau_id' => 4,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 5,
            'type_frais_id' => 1,
            'montant' => 10000,
            'niveau_id' => 5,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 6,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 6,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        //Frais d'inscription College et lycée
        Frais::create([
            'id' => 7,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 7,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 8,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 8,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 9,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 9,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 10,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 10,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 11,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 11,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 12,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 12,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 13,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 13,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 14,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 14,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 15,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 15,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 16,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 16,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 17,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 17,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 18,
            'type_frais_id' => 1,
            'montant' => 15000,
            'niveau_id' => 18,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);

        //Frais de scolarité Primaire
        Frais::create([
            'id' => 20,
            'type_frais_id' => 2,
            'montant' => 200000,
            'niveau_id' => 1,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 21,
            'type_frais_id' => 2,
            'montant' => 200000,
            'niveau_id' => 2,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 22,
            'type_frais_id' => 2,
            'montant' => 220000,
            'niveau_id' => 3,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 23,
            'type_frais_id' => 2,
            'montant' => 220000,
            'niveau_id' => 4,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 24,
            'type_frais_id' => 2,
            'montant' => 220000,
            'niveau_id' => 5,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 25,
            'type_frais_id' => 2,
            'montant' => 230000,
            'niveau_id' => 6,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        //Frais d'inscription College et lycée
        Frais::create([
            'id' => 26,
            'type_frais_id' => 2,
            'montant' => 250000,
            'niveau_id' => 7,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 27,
            'type_frais_id' => 2,
            'montant' => 250000,
            'niveau_id' => 8,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 28,
            'type_frais_id' => 2,
            'montant' => 250000,
            'niveau_id' => 9,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 29,
            'type_frais_id' => 2,
            'montant' => 270000,
            'niveau_id' => 10,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 30,
            'type_frais_id' => 2,
            'montant' => 300000,
            'niveau_id' => 11,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 31,
            'type_frais_id' => 2,
            'montant' => 320000,
            'niveau_id' => 12,
            'niveau_id' => 11,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 32,
            'type_frais_id' => 2,
            'montant' => 320000,
            'niveau_id' => 13,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 33,
            'type_frais_id' => 2,
            'montant' => 345000,
            'niveau_id' => 14,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 34,
            'type_frais_id' => 2,
            'montant' => 340000,
            'niveau_id' => 15,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 35,
            'type_frais_id' => 2,
            'montant' => 350000,
            'niveau_id' => 16,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 36,
            'type_frais_id' => 2,
            'montant' => 370000,
            'niveau_id' => 17,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
        Frais::create([
            'id' => 37,
            'type_frais_id' => 2,
            'montant' => 360000,
            'niveau_id' => 18,
            'annee_id' => 2,
            'etablissement_id' => 1,
        ]);
    }
}
