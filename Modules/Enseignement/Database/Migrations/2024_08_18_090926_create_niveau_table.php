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
        Schema::create('niveaus', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Cycle::class)->index()
                ->references('id')->on('cycles');
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
        Schema::dropIfExists('niveaus');
    }
};
