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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('ville');
            $table->boolean('statut');
            $table->string('logo')->nullable();
            $table->foreignIdFor(\App\Models\TypeEtablissement::class)->index()
                ->references('id')->on('type_etablissements');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('etablissement_section', function (Blueprint $table) {
            $table->id();
            $table->integer('regime_evaluation')->nullable();
            $table->foreignIdFor(\App\Models\Etablissement::class)
                ->index()
                ->references('id')->on('etablissements');
            $table->foreignIdFor(\App\Models\Section::class)
                ->index()
                ->references('id')->on('sections');
            $table->foreignIdFor(\App\Models\SystemeLmd::class)->nullable()->index()
                ->references('id')->on('systeme_lmds');
            $table->integer('configuration')->nullable();
            $table->timestamps();
        });

        Schema::create('etablissement_type_frais', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Scolarite\Entities\TypeFrais::class)
                ->index()
                ->references('id')->on('type_frais');
            $table->foreignIdFor(\App\Models\Etablissement::class)
                ->index()
                ->references('id')->on('etablissements');
            $table->integer('statut')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE etablissement_section ADD COLUMN code varchar(255);");

        DB::unprepared('
            CREATE TRIGGER etablissement_section_before_insert BEFORE INSERT ON etablissement_section
            FOR EACH ROW
            BEGIN
                DECLARE etablissement_name VARCHAR(255);
                DECLARE section_libelle VARCHAR(255);

                SELECT etablissements.name INTO etablissement_name
                FROM etablissements
                WHERE id = NEW.etablissement_id;

                SELECT sections.libelle INTO section_libelle
                FROM sections
                WHERE id = NEW.section_id;

                SET NEW.code = CONCAT(etablissement_name, "/", section_libelle);
            END;
        ');





    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etablissements');
    }
};
