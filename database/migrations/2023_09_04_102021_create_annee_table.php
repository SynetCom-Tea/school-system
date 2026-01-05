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
        Schema::create('annees', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->bigInteger('actif')->default(0);
            $table->foreignId('etablissement_section_id')->nullable()->constrained('etablissement_section')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Unicité métier
            $table->unique(['libelle', 'etablissement_section_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annees');
        // Schema::table('annees', function (Blueprint $table) {
        //     $table->dropForeign(['etablissement_section_id']);
        // });
    }
};
