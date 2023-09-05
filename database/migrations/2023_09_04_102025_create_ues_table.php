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
        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignIdFor(\Modules\Enseignement\Entities\CycleFiliere::class)->nullable()
                ->index()
                ->references('id')->on('cycle_filieres');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->index()
                ->references('id')->on('niveaux');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ues');
    }
};
