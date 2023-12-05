<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\FiliereNiveauMatiereUe;
use Modules\Enseignement\Entities\Matiere;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enseignement_annees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Enseignant::class)
                ->index()
                ->references('id')->on('enseignants');
            $table->foreignIdFor(\Modules\Enseignement\Entities\NiveauMatiere::class)->nullable()
            ->index()
            ->references('id')->on('niveau_matieres');
            $table->foreignIdFor(\App\Models\ClasseAnnee::class)
            ->index()
            ->references('id')->on('classe_annees');
            $table->foreignIdFor(FiliereNiveauMatiereUe::class)->nullable()
                ->index()
                ->references('id')->on('filiere_niveau_matiere_ues');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE enseignement_annees ADD COLUMN code varchar(255);");


        DB::unprepared("
        CREATE TRIGGER enseignement_annees_before_insert BEFORE INSERT ON enseignement_annees
        FOR EACH ROW
        BEGIN
            DECLARE classe VARCHAR(255);
            DECLARE grouper VARCHAR(255);
            DECLARE matiere VARCHAR(255);
            DECLARE module VARCHAR(255);
            DECLARE cycle VARCHAR(255);
            DECLARE filiere VARCHAR(255);
            DECLARE niveau VARCHAR(255);

            SELECT classes.code INTO classe
            FROM classes
            JOIN classe_annees ON classes.id = classe_annees.classe_id
            JOIN niveau_matieres nm ON nm.id = NEW.niveau_matiere_id
            WHERE classe_annees.id = NEW.classe_annee_id AND nm.id = NEW.niveau_matiere_id;
            SELECT classes.code INTO grouper
            FROM classes
            JOIN classe_annees ON classes.id = classe_annees.classe_id
            JOIN filiere_niveau_matiere_ues fnmu ON fnmu.id = NEW.filiere_niveau_matiere_ue_id
            WHERE classe_annees.id = NEW.classe_annee_id AND fnmu.id = NEW.filiere_niveau_matiere_ue_id;
            SELECT m.nom INTO matiere
            FROM matieres m
            JOIN niveau_matieres nm ON m.id = nm.matiere_id
            WHERE nm.id = NEW.niveau_matiere_id;
            SELECT cy.name,m.nom,f.name,n.libelle INTO cycle,module,filiere,niveau
            FROM matieres m
            JOIN filiere_niveau_matiere_ues fnmu ON m.id = fnmu.matiere_id
            JOIN niveaux n ON n.id = fnmu.niveau_id
            JOIN cycle_filieres cf ON cf.id = fnmu.cycle_filiere_id
            JOIN cycles cy ON cy.id = cf.cycle_id
            JOIN filieres f ON f.id = cf.filiere_id
            WHERE fnmu.id = NEW.filiere_niveau_matiere_ue_id;
            IF NEW.niveau_matiere_id IS NOT NULL
            THEN
            SET NEW.code = CONCAT(classe, '/', matiere);
            END IF;
            IF NEW.niveau_matiere_id IS NULL
            THEN
            SET NEW.code = CONCAT(filiere,'/',niveau,'/',cycle,'/',grouper, '/', module);
            END IF ;
        END;
    ");
        Schema::create('enseignant_matieres', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Matiere::class)
                ->nullable()->index()
                ->references('id')->on('matieres');
            $table->foreignIdFor(Enseignant::class)->nullable()
                ->index()
                ->references('id')->on('enseignants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignement_annees');
    }
};
