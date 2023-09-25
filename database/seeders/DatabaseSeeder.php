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
            EtablissementSectionSeeder::class,
            ClasseSeeder::class,
            AnneeScolaireSeeder::class,
            ClasseAnneeSeeder::class,
            TuteursSeeder::class,
            ApprenantSeeder::class,
            // SalleSeeder::class,

            // EnseignementDatabaseSeeder::class,
        ]);
    }
}



// <?php

// namespace Database\Seeders;

// // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use Modules\Enseignement\Database\Seeders\EnseignementDatabaseSeeder;

// class DatabaseSeeder extends Seeder
// {
//     /**
//      * Seed the application's database.
//      */
//     public function run(): void
//     {
//         $this->call([
//             PermissionSeeder::class,
//             RoleSeeder::class,
//             TypeEtablissementSeeder::class,
//             SectionSeeder::class,
//             NiveauTableSeeder::class
//             // EtablissementsTableSeeder::class,
//             // ClasseSeeder::class,
//             // AnneeScolaireSeeder::class,
//             // ClasseAnneeSeeder::class,
//             // ApprenantSeeder::class,
//             // SalleSeeder::class,
//             // EtablissementSectionSeeder::class,
//             // EnseignementDatabaseSeeder::class,
//         ]);
//     }
// }
