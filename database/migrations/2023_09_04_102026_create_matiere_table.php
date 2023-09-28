<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                DECLARE etablissement_name VARCHAR(255);
                DECLARE section_libelle VARCHAR(255);
        
                SELECT etablissements.name INTO etablissement_name
                FROM etablissements
                JOIN etablissement_section ON etablissements.id = etablissement_section.etablissement_id
                WHERE etablissement_section.id = NEW.etablissement_section_id;
        
                SELECT sections.libelle INTO section_libelle
                FROM sections
                JOIN etablissement_section ON sections.id = etablissement_section.section_id
                WHERE etablissement_section.id = NEW.etablissement_section_id;
        
                SET NEW.code = CONCAT(etablissement_name, "/", section_libelle, "/", NEW.nom);
            END;
        ');

        Schema::create('filiere_matiere_ues_', function (Blueprint $table) {
            $table->id();
            $table->string('volume_horaire')->nullable();
            $table->string('coefficient')->nullable();
            $table->foreignIdFor(\Modules\Enseignement\Entities\CycleFiliere::class)
                ->nullable()->index()
                ->references('id')->on('cycle_filieres');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Matiere::class)
                ->nullable()->index()
                ->references('id')->on('matieres');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Ue::class)
                ->nullable()->index()
                ->references('id')->on('ues');
        });

        Schema::create('niveau_matieres', function (Blueprint $table) {
            $table->id();
            $table->string('volume_horaire')->nullable();
            $table->string('coefficient')->nullable();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->index()
                ->references('id')->on('niveaux');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Matiere::class)
                ->nullable()->index()
                ->references('id')->on('matieres');
            $table->foreignIdFor(\Modules\Enseignement\Entities\FiliereMatiereUe::class)->nullable()
                ->index()
                ->references('id')->on('filiere_matiere_ues_');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
