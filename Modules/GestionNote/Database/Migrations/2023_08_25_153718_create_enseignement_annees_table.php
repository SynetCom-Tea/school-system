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
        Schema::create('enseignement_annees', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignIdFor(Modules\GestionNote\Entities\Enseignant::class)
                ->index()
                ->references('id')->on('enseignants');
            $table->foreignIdFor(Modules\GestionNote\Entities\NiveauMatiere::class)
            ->index()
            ->references('id')->on('niveau_matieres');
            $table->foreignIdFor(Modules\GestionNote\Entities\ClasseAnnee::class)
            ->index()
            ->references('id')->on('classe_annees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignement_annees');
    }
};
