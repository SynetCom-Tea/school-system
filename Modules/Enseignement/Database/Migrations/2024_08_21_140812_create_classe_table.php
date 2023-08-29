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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('effectif');
            $table->timestamps();
        });
        Schema::create('classe_annees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Clase::class)
                ->index()
                ->references('id')->on('classes');
            $table->foreignIdFor(\Modules\Enseignement\Entities\AnneeScolaire::class)
                ->index()
                ->references('id')->on('annee_scolaires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
