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
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('nom');
            $table->string('prenom');
            $table->timestamps();
        });

        Schema::create('apprenant_classe_annee', function (Blueprint $table) {
            
            $table->foreignIdFor(\App\Models\Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(\App\Models\ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
        });

        DB::statement("ALTER TABLE apprenants ADD COLUMN nom_complet varchar(255)
        GENERATED ALWAYS AS (CONCAT(nom,' ',prenom));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenants');
    }
};
