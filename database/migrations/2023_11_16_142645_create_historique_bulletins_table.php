<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Apprenant;
use App\Models\ClasseAnnee;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historique_bulletins', function (Blueprint $table) {
            $table->id();
            $table->boolean('statut')->default(1);
            $table->foreignIdFor(Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
            $table->string('periode');
            $table->string('matricule_apprenant');
            $table->string('nom_prenom_apprenant');
            $table->string('nom_classe');
            $table->string('moyenne_details_notes');
            $table->string('rang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_bulletins');
    }
};
