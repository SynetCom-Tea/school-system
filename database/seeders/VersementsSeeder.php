<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Scolarite\Entities\Versement;

class VersementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        ///Apprenant1
        Versement::create([
            'id' => 1,
            'frais_id' => 3,
            'libelle' => 'Versement de frais d\'inscription',
            'montant' => 10000,
            'apprenant_id' => 1,
            'date_versement' => "2023-09-22"
        ]);

        Versement::create([
            'id' => 2,
            'frais_id' => 22,
            'libelle' => 'Versement 1 Frais de scolarité',
            'montant' => 100000,
            'apprenant_id' => 1,
            'date_versement' => "2023-09-22"
        ]);
        ///Apprenant2
        Versement::create([
            'id' => 3,
            'frais_id' => 6,
            'libelle' => 'Versement de frais d\'inscription',
            'montant' => 10000,
            'apprenant_id' => 2,
            'date_versement' => "2023-09-22"
        ]);

        Versement::create([
            'id' => 4,
            'frais_id' => 25,
            'libelle' => 'Versement 1 Frais de scolarité',
            'montant' => 100000,
            'apprenant_id' => 2,
            'date_versement' => "2023-09-22"
        ]);

        ///Apprenant3
        Versement::create([
            'id' => 5,
            'frais_id' => 8,
            'libelle' => 'Versement de frais d\'inscription',
            'montant' => 15000,
            'apprenant_id' => 3,
            'date_versement' => "2023-09-22"
        ]);

        Versement::create([
            'id' => 6,
            'frais_id' => 27,
            'libelle' => 'Versement 1 Frais de scolarité',
            'montant' => 150000,
            'apprenant_id' => 2,
            'date_versement' => "2023-09-22"
        ]);

        ///Apprenant4
        Versement::create([
            'id' => 7,
            'frais_id' => 10,
            'libelle' => 'Versement de frais d\'inscription',
            'montant' => 15000,
            'apprenant_id' => 4,
            'date_versement' => "2023-06-22"
        ]);

        Versement::create([
            'id' => 8,
            'frais_id' => 29,
            'libelle' => 'Versement 1 Frais de scolarité',
            'montant' => 150000,
            'apprenant_id' => 2,
            'date_versement' => "2023-06-22"
        ]);

        ///Apprenant5
        Versement::create([
            'id' => 9,
            'frais_id' => 11,
            'libelle' => 'Versement de frais d\'inscription',
            'montant' => 15000,
            'apprenant_id' => 4,
            'date_versement' => "2023-07-22"
        ]);

        Versement::create([
            'id' => 10,
            'frais_id' => 30,
            'libelle' => 'Versement 1 Frais de scolarité',
            'montant' => 150000,
            'apprenant_id' => 2,
            'date_versement' => "2023-07-22"
        ]);
        ///Apprenant6
        Versement::create([
            'id' => 11,
            'frais_id' => 18,
            'libelle' => 'Versement de frais d\'inscription',
            'montant' => 15000,
            'apprenant_id' => 4,
            'date_versement' => "2023-08-22"
        ]);

        Versement::create([
            'id' => 12,
            'frais_id' => 37,
            'libelle' => 'Versement 1 Frais de scolarité',
            'montant' => 150000,
            'apprenant_id' => 2,
            'date_versement' => "2023-08-22"
        ]);
    }
}
