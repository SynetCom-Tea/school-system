<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Enseignement\Entities\Niveau;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->foreignIdFor(\App\Models\EtablissementSection::class)->nullable()
                ->index()
                ->references('id')->on('etablissement_section');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE matieres ADD COLUMN code varchar(255);");

        DB::unprepared('
            CREATE TRIGGER matieres_before_insert BEFORE INSERT ON matieres
            FOR EACH ROW
            BEGIN
                DECLARE section_libelle VARCHAR(255);

                SELECT sections.libelle INTO section_libelle
                FROM sections
                JOIN etablissement_section ON sections.id = etablissement_section.section_id
                WHERE etablissement_section.id = NEW.etablissement_section_id;

                SET NEW.code = CONCAT(section_libelle, "/", NEW.nom);
            END;
        ');

        Schema::create('filiere_niveau_matiere_ues', function (Blueprint $table) {
            $table->id();
            $table->string('volume_horaire')->nullable();
            $table->string('coefficient')->nullable();
            $table->foreignIdFor(\Modules\Enseignement\Entities\CycleFiliere::class)
                ->nullable()->index()
                ->references('id')->on('cycle_filieres');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Matiere::class)
                ->nullable()->index()
                ->references('id')->on('matieres');
            $table->foreignIdFor(Niveau::class)
                ->nullable()->index()
                ->references('id')->on('niveaux');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Ue::class)
                ->nullable()->index()
                ->references('id')->on('ues');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('niveau_matieres', function (Blueprint $table) {
            $table->id();
            $table->string('volume_horaire')->nullable();
            $table->string('coefficient')->nullable();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->index()
                ->references('id')->on('niveaux');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Matiere::class)->nullable()
                ->index()
                ->references('id')->on('matieres');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE niveau_matieres ADD COLUMN code varchar(255);");

        DB::unprepared('
            CREATE TRIGGER niveau_matieres_before_insert BEFORE INSERT ON niveau_matieres
            FOR EACH ROW
            BEGIN
                DECLARE matiere VARCHAR(255);
                DECLARE niveau VARCHAR(255);

                SELECT matieres.nom INTO matiere
                FROM matieres
                WHERE matieres.id = NEW.matiere_id;

                SELECT niveaux.code INTO niveau
                FROM niveaux
                WHERE niveaux.id = NEW.niveau_id;

                SET NEW.code = CONCAT(matiere, "/", niveau);
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
