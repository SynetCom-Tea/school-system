<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            TypeEtablissementSeeder::class,
            SectionSeeder::class,
            NiveauTableSeeder::class,
            EtablissementsTableSeeder::class,
            RoleSeeder::class,
            EtablissementSectionSeeder::class,
            ClasseSeeder::class,
            AnneeScolaireSeeder::class,
            ClasseAnneeSeeder::class,
            ApprenantSeeder::class,
            // SalleSeeder::class,

            // EnseignementDatabaseSeeder::class,
        ]);
    }
}
