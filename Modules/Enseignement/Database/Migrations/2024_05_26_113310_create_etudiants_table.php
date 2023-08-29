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
        Schema::dropIfExists('etudiants');
    }
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('civilite')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('nom_complete')->nullable();
            $table->string('nom_jeune_fille')->nullable();
            $table->string('date_naiss')->nullable();
            $table->string('lieu_naiss')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('sexe')->nullable();
            $table->string('adress1')->nullable();
            $table->string('adress2')->nullable();
            $table->string('localite')->nullable();
            $table->string('tel')->nullable();
            $table->string('mail')->nullable();
            $table->string('profession_pere')->nullable();
            $table->string('profession_mere')->nullable();
            $table->string('extrait_naiss')->nullable();
            $table->string('extrait_nation')->nullable();
            $table->string('handicap')->nullable();
            $table->binary('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    
};
