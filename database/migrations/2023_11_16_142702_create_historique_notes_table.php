<?php

use App\Models\HistoriqueBulletin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Enseignement\Entities\Matiere;
use Modules\Enseignement\Entities\Ue;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historique_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HistoriqueBulletin::class)
                ->index()
                ->references('id')->on('historique_bulletins');
            $table->foreignIdFor(Matiere::class)->nullable()
                ->index()
                ->references('id')->on('matieres');
            $table->foreignIdFor(Ue::class)->nullable()
                ->index()
                ->references('id')->on('ues');
            $table->string('nom_eu')->nullable();
            $table->string('nom_matiere');
            $table->string('coefficient');
            $table->string('notation_matiere')->nullable();
            $table->string('note')->nullable();
            $table->double('note_de_classe')->nullable();
            $table->double('note_de_classe_coefficiente')->nullable();
            $table->string('note_de_composition')->nullable();
            $table->string('note_de_composition_coefficiente')->nullable();
            $table->string('moyenne')->nullable();
            $table->string('moyenne_coefficiente')->nullable();
            $table->double('note_origine_devoir')->nullable();
            $table->double('note_origine_examen')->nullable();
            $table->string('note_devoir_pourcentage')->nullable();
            $table->string('note_examen_pourcentage')->nullable();
            $table->string('volume_horaire_matiere')->nullable();
            $table->string('note_generale')->nullable();
            $table->string('note_generale_coefficiente')->nullable();
            $table->boolean('session')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_notes');
    }
};
