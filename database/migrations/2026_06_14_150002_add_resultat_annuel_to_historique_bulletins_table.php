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
            $table->decimal('moyenne_annuelle', 4, 2)->nullable();
            $table->decimal('plus_forte_moyenne_annuelle', 4, 2)->nullable();
            $table->decimal('plus_faible_moyenne_annuelle', 4, 2)->nullable();
            $table->decimal('moyenne_semestre_1', 4, 2)->nullable();
            $table->decimal('moyenne_semestre_2', 4, 2)->nullable();
            $table->string('rang_semestre_1')->nullable();
            $table->string('rang_semestre_2')->nullable();
            $table->string('rang_annuel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historique_bulletins', function (Blueprint $table) {
            $table->dropColumn('moyenne_annuelle');
            $table->dropColumn('rang_annuel');
            $table->dropColumn('plus_forte_moyenne_annuelle');
            $table->dropColumn('plus_faible_moyenne_annuelle');
            $table->dropColumn('moyenne_semestre_1');
            $table->dropColumn('moyenne_semestre_2');
            $table->dropColumn('rang_semestre_1');
            $table->dropColumn('rang_semestre_2');
        });
    }
};
