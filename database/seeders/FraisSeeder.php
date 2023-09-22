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
            'libelle' => 'Frais d\'inscription',
            'montant' => 10000,
            'niveau_id' => 1,
        ]);
        Frais::create([
            'id' => 2,
            'libelle' => 'Frais d\'inscription',
            'montant' => 10000,
            'niveau_id' => 2,
        ]);
        Frais::create([
            'id' => 3,
            'libelle' => 'Frais d\'inscription',
            'montant' => 10000,
            'niveau_id' => 3,
        ]);
        Frais::create([
            'id' => 4,
            'libelle' => 'Frais d\'inscription',
            'montant' => 10000,
            'niveau_id' => 4,
        ]);
        Frais::create([
            'id' => 5,
            'libelle' => 'Frais d\'inscription',
            'montant' => 10000,
            'niveau_id' => 5,
        ]);
        Frais::create([
            'id' => 6,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 6,
        ]);
        //Frais d'inscription College et lycée
        Frais::create([
            'id' => 7,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 7,
        ]);
        Frais::create([
            'id' => 8,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 8,
        ]);
        Frais::create([
            'id' => 9,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 9,
        ]);
        Frais::create([
            'id' => 10,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 10,
        ]);
        Frais::create([
            'id' => 11,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 11,
        ]);
        Frais::create([
            'id' => 12,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 12,
        ]);
        Frais::create([
            'id' => 13,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 13,
        ]);
        Frais::create([
            'id' => 14,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 14,
        ]);
        Frais::create([
            'id' => 15,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 15,
        ]);
        Frais::create([
            'id' => 16,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 16,
        ]);
        Frais::create([
            'id' => 17,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 17,
        ]);
        Frais::create([
            'id' => 18,
            'libelle' => 'Frais d\'inscription',
            'montant' => 15000,
            'niveau_id' => 18,
        ]);

        //Frais de scolarité Primaire
        Frais::create([
            'id' => 20,
            'libelle' => 'Frais de scolarite',
            'montant' => 200000,
            'niveau_id' => 1,
        ]);
        Frais::create([
            'id' => 21,
            'libelle' => 'Frais de scolarite',
            'montant' => 200000,
            'niveau_id' => 2,
        ]);
        Frais::create([
            'id' => 22,
            'libelle' => 'Frais de scolarite',
            'montant' => 220000,
            'niveau_id' => 3,
        ]);
        Frais::create([
            'id' => 23,
            'libelle' => 'Frais de scolarite',
            'montant' => 220000,
            'niveau_id' => 4,
        ]);
        Frais::create([
            'id' => 24,
            'libelle' => 'Frais de scolarite',
            'montant' => 220000,
            'niveau_id' => 5,
        ]);
        Frais::create([
            'id' => 25,
            'libelle' => 'Frais de scolarite',
            'montant' => 230000,
            'niveau_id' => 6,
        ]);
        //Frais d'inscription College et lycée
        Frais::create([
            'id' => 26,
            'libelle' => 'Frais de scolarite',
            'montant' => 250000,
            'niveau_id' => 7,
        ]);
        Frais::create([
            'id' => 27,
            'libelle' => 'Frais de scolarite',
            'montant' => 250000,
            'niveau_id' => 8,
        ]);
        Frais::create([
            'id' => 28,
            'libelle' => 'Frais de scolarite',
            'montant' => 250000,
            'niveau_id' => 9,
        ]);
        Frais::create([
            'id' => 29,
            'libelle' => 'Frais de scolarite',
            'montant' => 270000,
            'niveau_id' => 10,
        ]);
        Frais::create([
            'id' => 30,
            'libelle' => 'Frais de scolarite',
            'montant' => 300000,
            'niveau_id' => 11,
        ]);
        Frais::create([
            'id' => 31,
            'libelle' => 'Frais de scolarite',
            'montant' => 320000,
            'niveau_id' => 12,
            'niveau_id' => 11,
        ]);
        Frais::create([
            'id' => 32,
            'libelle' => 'Frais de scolarite',
            'montant' => 320000,
            'niveau_id' => 13,
        ]);
        Frais::create([
            'id' => 33,
            'libelle' => 'Frais de scolarite',
            'montant' => 345000,
            'niveau_id' => 14,
        ]);
        Frais::create([
            'id' => 34,
            'libelle' => 'Frais de scolarite',
            'montant' => 340000,
            'niveau_id' => 15,
        ]);
        Frais::create([
            'id' => 35,
            'libelle' => 'Frais de scolarite',
            'montant' => 350000,
            'niveau_id' => 16,
        ]);
        Frais::create([
            'id' => 36,
            'libelle' => 'Frais de scolarite',
            'montant' => 370000,
            'niveau_id' => 17,
        ]);
        Frais::create([
            'id' => 37,
            'libelle' => 'Frais de scolarite',
            'montant' => 360000,
            'niveau_id' => 18,
        ]);
    }
}
