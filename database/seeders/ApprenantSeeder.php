<?php

namespace Database\Seeders;

use App\Models\Apprenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apprenant::create([
            'matricule' => 'Mat/093',
            'nom' => 'Sani Abou',
            'prenom' => 'Mahamadou',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/094',
            'nom' => 'Djafar Alambouzou',
            'prenom' => 'Madougou',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/095',
            'nom' => 'Karim Tankari',
            'prenom' => 'Alfari',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/043',
            'nom' => 'Sani Chipkaou',
            'prenom' => 'Kadidja',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/013',
            'nom' => 'Wahab Dan Takoussa',
            'prenom' => 'Rouwaida',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/099',
            'nom' => 'Garba Labizé',
            'prenom' => 'Bello',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/063',
            'nom' => 'Djibo Dan Malam',
            'prenom' => 'Mayaki',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/066',
            'nom' => 'Nourou Hainikoy',
            'prenom' => 'Bouchira',
        ]);
        Apprenant::create([
            'matricule' => 'Mat/055',
            'nom' => 'Nafiou Bonkaney',
            'prenom' => 'Wazir',
        ]);
    }
}
