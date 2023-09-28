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
            $table->string('code')->nullable();
            $table->string('nom')->nullable();
            $table->foreignIdFor(\App\Models\EtablissementSection::class)->nullable()
                ->index()
                ->references('id')->on('etablissement_section');
            $table->timestamps();
        });

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
            $table->timestamps();
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
