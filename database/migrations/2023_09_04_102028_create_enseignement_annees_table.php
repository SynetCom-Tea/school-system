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

        DB::unprepared('
            CREATE TRIGGER enseignement_annees_before_insert BEFORE INSERT ON enseignement_annees
            FOR EACH ROW
            BEGIN
                DECLARE classe VARCHAR(255);
                DECLARE matiere VARCHAR(255);

                SELECT classes.libelle INTO classe
                FROM classes
                JOIN classe_annees ON classes.id = classe_annees.classe_id
                WHERE classe_annees.id = NEW.classe_annee_id;

                SELECT matieres.nom INTO matiere
                FROM matieres
                JOIN niveau_matieres ON matieres.id = niveau_matieres.matiere_id
                WHERE niveau_matieres.id = NEW.niveau_matiere_id;

                SET NEW.code = CONCAT(classe, "/", matiere);
            END;
        ');


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
