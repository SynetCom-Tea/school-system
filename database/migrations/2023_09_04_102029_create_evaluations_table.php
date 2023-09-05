<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->integer('pourcentage')->nullable();
            $table->integer('statut')->nullable();
            $table->foreignIdFor(\Modules\GestionNote\Entities\Periode::class)->nullable()
                ->index()
                ->references('id')
                ->on('periodes');
            $table->foreignIdFor(\Modules\GestionNote\Entities\TypeEvaluation::class)->nullable()
            ->index()
            ->references('id')
            ->on('type_evaluations');
            $table->foreignIdFor(\Modules\Enseignement\Entities\EnseignementAnnee::class)->nullable()
                ->index()
                ->references('id')
                ->on('enseignement_annees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */

};
