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
        Schema::table('historique_bulletins', function (Blueprint $table) {
            $table->string('annee_scolaire')->nullable();
            $table->integer('classe_effectif')->nullable();
            $table->float('moyenne_litteraire')->nullable();
            $table->float('moyenne_scientifique')->nullable();
            $table->float('moyenne_autres_matieres')->nullable();
            $table->float('classe_forte_moyenne')->nullable();
            $table->float('classe_faible_moyenne')->nullable();
            $table->float('classe_moyenne')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historique_bulletins', function (Blueprint $table) {
            //
            $table->dropColumn([
            'annee_scolaire', 
            'classe_effectif', 
            'moyenne_litteraire', 
            'moyenne_scientifique', 
            'moyenne_autres_matieres', 
            'classe_forte_moyenne', 
            'classe_faible_moyenne',
            'classe_moyenne'
            ]);
        });
    }
};
