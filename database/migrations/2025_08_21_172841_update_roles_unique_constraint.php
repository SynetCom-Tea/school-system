<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    // Supprimez l'ancienne contrainte d'unicité
    Schema::table('roles', function (Blueprint $table) {
        $table->dropUnique(['name', 'guard_name']);
    });

    // Créez une nouvelle contrainte qui inclut etablissement_section_id
    Schema::table('roles', function (Blueprint $table) {
        $table->unique(['name', 'guard_name', 'etablissement_section_id']);
    });
}

public function down()
{
    Schema::table('roles', function (Blueprint $table) {
        $table->dropUnique(['name', 'guard_name', 'etablissement_section_id']);
    });

    Schema::table('roles', function (Blueprint $table) {
        $table->unique(['name', 'guard_name']);
    });
}
};
