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
        Schema::create('classe_annees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Modules\GestionNote\Entities\Annee::class)
                ->index()
                ->references('id')->on('annees');
            $table->foreignIdFor(Modules\GestionNote\Entities\Classe::class)
            ->index()
            ->references('id')->on('classes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_annees');
    }
};
