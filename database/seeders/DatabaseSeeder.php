<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ApprenantClasseAnnee;
use Illuminate\Database\Seeder;
use Database\Seeders\FiliereSeeder;
use Modules\Enseignement\Database\Seeders\EnseignantMatiereSeeder;
use Modules\Enseignement\Database\Seeders\EnseignantTableSeeder;

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
            EtablissementSectionTableSeeder::class,
            ClassesTableSeeder::class,
            AnneeScolaireSeeder::class,
            ClasseAnneesTableSeeder::class,
            TuteursSeeder::class,
            ApprenantsTableSeeder::class,
            // EnseignantsTableSeeder::class,
            TypeFraisSeeder::class,
            // FraisSeeder::class,
            RoleSeeder::class,
            InscriptionsTableSeeder::class,
            // VersementsTableSeeder::class,
            ApprenantClasseAnneesTableSeeder::class,
            SallesTableSeeder::class,
            MatieresTableSeeder::class,
            // NiveauMatieresTableSeeder::class,

            // FraisSeeder::class,
            // VersementsSeeder::class,
            // ApprenantClasseAnneesSeeder::class,
            PeriodeTableSeeder::class,
            TypeEvaluationTableSeeder::class,
            // EvaluationsTableSeeder::class,
            // EnseignantTableSeeder::class,
            // EnseignementAnneesTableSeeder::class,
            // EnseignantMatieresTableSeeder::class,
            // EnseignantSeeder::class,
            // EnseignantMatiereSeeder::class,
        ]);
        // $this->call(TypeEtablissementsTableSeeder::class);
        // $this->call(SectionsTableSeeder::class);
        // $this->call(EtablissementsTableSeeder::class);
        // $this->call(EtablissementSectionTableSeeder::class);
        // $this->call(ClassesTableSeeder::class);
        // $this->call(ClasseAnneesTableSeeder::class);
        // $this->call(TuteursTableSeeder::class);  
        // $this->call(ApprenantsTableSeeder::class);
        // $this->call(EnseignantsTableSeeder::class);
        // $this->call(FraisTableSeeder::class);
        // $this->call(VersementsTableSeeder::class);
        // $this->call(ApprenantClasseAnneesTableSeeder::class);
        // $this->call(SallesTableSeeder::class);
        // $this->call(MatieresTableSeeder::class);
        // $this->call(NiveauMatieresTableSeeder::class);
        // $this->call(EnseignantMatieresTableSeeder::class);
        // $this->call(EnseignementAnneesTableSeeder::class);
        // $this->call(InscriptionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(EvaluationsTableSeeder::class);
        // $this->call(NotesTableSeeder::class);
    }
}

