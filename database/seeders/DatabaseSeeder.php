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
            // PermissionSeeder::class,
            SectionSeeder::class,
            TypeEtablissementSeeder::class,
            EtablissementsTableSeeder::class,
            RoleSeeder::class,
            // NiveauTableSeeder::class
            // EtablissementsTableSeeder::class,
            // ClasseSeeder::class,
            // AnneeScolaireSeeder::class,
            // ClasseAnneeSeeder::class,
            // ApprenantSeeder::class,
            // SalleSeeder::class,
            // EtablissementSectionSeeder::class,
            // EnseignementDatabaseSeeder::class,
        ]);
    }
}
