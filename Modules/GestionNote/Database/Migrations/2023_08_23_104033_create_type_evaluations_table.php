<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_evaluations');
    }
    public function up(): void
    {
        Schema::create('type_evaluations', function (Blueprint $table) {
            $table->id();
            $table->integer('libelle')->nullable();
            $table->integer('statut')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */

};
