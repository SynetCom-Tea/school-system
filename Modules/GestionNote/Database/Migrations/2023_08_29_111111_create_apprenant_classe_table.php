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
        Schema::create('apprenant_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Modules\GestionNote\Entities\Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(Modules\GestionNote\Entities\ClasseAnnee::class)
            ->index()
            ->references('id')->on('classe_annees');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenant_classes');
    }
};
