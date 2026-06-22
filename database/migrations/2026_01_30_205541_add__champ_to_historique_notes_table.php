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
        Schema::table('historique_notes', function (Blueprint $table) {
            if (!Schema::hasColumn('historique_notes', 'rang_matiere')) {
                $table->string('rang_matiere')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historique_notes', function (Blueprint $table) {
            if (Schema::hasColumn('historique_notes', 'rang_matiere')) {
                $table->dropColumn('rang_matiere');
            }
        });
    }
};
