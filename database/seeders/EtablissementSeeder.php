<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apprenant;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etablissement::create([
            'name' => 'IAI-Niger',
            'email' => 'iainiger@gmail.com',
            'adresse' => 'Plateau',
            'telephone' => 'Mahamadou',
            'ville' => 'Mahamadou',
            'statut' => 'Mahamadou',
            'logo' => 'Mahamadou',
            'type_etablissement_id' => 'Mahamadou',
            'systeme_lmd_id' => 'Mahamadou',
            'logo' => 'Mahamadou',
        ]);
    }
}
