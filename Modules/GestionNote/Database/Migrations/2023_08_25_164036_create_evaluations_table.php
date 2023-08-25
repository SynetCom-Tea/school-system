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
            $table->foreignIdFor(Modules\GestionNote\Entities\Periode::class)->nullable()
                ->index()
                ->references('id')
                ->on('periodes');
            $table->foreignIdFor(Modules\GestionNote\Entities\TypeEvaluation::class)->nullable()
            ->index()
            ->references('id')
            ->on('type_evaluations');
            $table->foreignIdFor(Modules\GestionNote\Entities\EnseignementAnnee::class)->nullable()
                ->index()
                ->references('id')
                ->on('enseignement_annees');
            $table->timestamps();
<<<<<<< HEAD:Modules/GestionNote/Database/Migrations/2023_08_23_104036_create_evaluations_table.php
           
=======
            $table->softDeletes();
>>>>>>> c61f7e47c680b06ebfc30ff6c678cf9eb2e63f2e:Modules/GestionNote/Database/Migrations/2023_08_25_164036_create_evaluations_table.php
        });
    }

    /**
     * Reverse the migrations.
     */

};
