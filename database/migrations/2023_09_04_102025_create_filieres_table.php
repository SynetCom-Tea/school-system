<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignIdFor(\App\Models\EtablissementSection::class)
            ->index()
            ->references('id')->on('etablissement_section');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Departement::class)->nullable()
                ->index()
                ->references('id')->on('departements');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('cycle_filieres', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cycle::class)->nullable()->index()
                ->references('id')->on('cycles');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Filiere::class)
                ->index()
                ->references('id')->on('filieres');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE cycle_filieres ADD COLUMN code varchar(255);");

        DB::unprepared('
            CREATE TRIGGER cycle_filieres_before_insert BEFORE INSERT ON cycle_filieres
            FOR EACH ROW
            BEGIN
                DECLARE filiere VARCHAR(255);
                DECLARE cycle VARCHAR(255);

                SELECT filieres.code INTO filiere
                FROM filieres
                WHERE filieres.id = NEW.filiere_id;

                SELECT cycles.name INTO cycle
                FROM cycles
                WHERE cycles.id = NEW.cycle_id;

                SET NEW.code = CONCAT(filiere, "/", cycle);
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
        Schema::dropIfExists('etablissement_filieres');
    }
};
