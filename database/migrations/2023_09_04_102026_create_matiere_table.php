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
            $table->foreignIdFor(\Modules\Enseignement\Entities\Ue::class)->nullable()
                ->index()
                ->references('id')->on('ues');
            $table->foreignIdFor(\Modules\Enseignement\Entities\CycleFiliere::class)->nullable()
                ->index()
                ->references('id')->on('cycle_filieres');
            $table->timestamps();
        });

        Schema::create('niveau_matieres', function (Blueprint $table) {
            $table->id();
            $table->string('volume_horaire')->nullable();
            $table->string('cefficient')->nullable();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->index()
                ->references('id')->on('niveaus');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Matiere::class)
                ->index()
                ->references('id')->on('matieres');
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
