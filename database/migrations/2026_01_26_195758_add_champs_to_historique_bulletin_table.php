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
            if (!Schema::hasColumn('historique_bulletins', 'annee_scolaire')) {
                $table->string('annee_scolaire')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'classe_effectif')) {
                $table->integer('classe_effectif')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'moyenne_litteraire')) {
                $table->float('moyenne_litteraire')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'moyenne_scientifique')) {
                $table->float('moyenne_scientifique')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'moyenne_autres_matieres')) {
                $table->float('moyenne_autres_matieres')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'classe_forte_moyenne')) {
                $table->float('classe_forte_moyenne')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'classe_faible_moyenne')) {
                $table->float('classe_faible_moyenne')->nullable();
            }
            if (!Schema::hasColumn('historique_bulletins', 'classe_moyenne')) {
                $table->float('classe_moyenne')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historique_bulletins', function (Blueprint $table) {
            $cols = [
                'annee_scolaire', 
                'classe_effectif', 
                'moyenne_litteraire', 
                'moyenne_scientifique', 
                'moyenne_autres_matieres', 
                'classe_forte_moyenne', 
                'classe_faible_moyenne',
                'classe_moyenne'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('historique_bulletins', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
