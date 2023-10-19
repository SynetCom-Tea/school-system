<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\FiliereSeeder;
use Modules\Enseignement\Database\Seeders\EnseignantMatiereSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CycleSeeder::class,
            PermissionSeeder::class,
            TypeEtablissementSeeder::class,
            SectionSeeder::class,
            TypeDocumentSeeder::class,
            NiveauTableSeeder::class,
            EtablissementsTableSeeder::class,
            EtablissementSectionSeeder::class,
            FiliereSeeder::class,
            CycleSeeder::class,
            CycleFiliereSeeder::class,
            ClasseSeeder::class,
            AnneeScolaireSeeder::class,
            ClasseAnneeSeeder::class,
            TypeFraisSeeder::class,
            TuteursSeeder::class,
            ApprenantSeeder::class,
            EnseignantSeeder::class,
            RoleSeeder::class,
            FraisSeeder::class,
            // VersementsSeeder::class,
            ApprenantClasseAnneesSeeder::class,
            SalleSeeder::class,
            MatiereTableSeeder::class,
            NiveauMatiereSeeder::class,
            FiliereNiveauUeMatiereSeeder::class,
            PeriodeTableSeeder::class,
            TypeEvaluationTableSeeder::class,
            
            // EnseignantSeeder::class,
            EnseiggnementAnneeSeeder::class,
            EnseignantMatiereSeeder::class,
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
