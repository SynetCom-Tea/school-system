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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('date_naiss')->nullable();
            $table->timestamps();
        });
        Schema::create('ensegnement_annees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Enseignant::class)
                ->index()
                ->references('id')->on('enseignants');
            $table->foreignIdFor(\Modules\Enseignement\Entities\NiveauMatiere::class)
                ->index()
                ->references('id')->on('niveau_matieres');
            $table->foreignIdFor(\Modules\Enseignement\Entities\ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignements');
    }
};
