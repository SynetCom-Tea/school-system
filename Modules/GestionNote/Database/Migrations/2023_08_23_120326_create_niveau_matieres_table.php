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
        Schema::create('niveau_matieres', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->foreignIdFor(Modules\GestionNote\Entities\Matiere::class)
                ->index()
                ->references('id')->on('Matieres');
            $table->foreignIdFor(Modules\GestionNote\Entities\Niveau::class)
                ->index()
                ->references('id')->on('Niveaux');
            $table->integer('coefficient')->nullable();
            $table->integer('volumeHoraire')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveau_matieres');
    }
};
