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
        Schema::table('matieres', function (Blueprint $table) {
            if (!Schema::hasColumn('matieres', 'type_matiere')) {
                $table->string('type_matiere')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('matieres', function (Blueprint $table) {
            if (Schema::hasColumn('matieres', 'type_matiere')) {
                $table->dropColumn('type_matiere');
            }
        });
    }
};
