<?php

use App\Models\HistoriqueBulletin;
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
        Schema::create('historique_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HistoriqueBulletin::class)
                ->index()
                ->references('id')->on('historique_bulletins');
            $table->string('nom_matiere');
            $table->string('coefficient');
            $table->double('note_de_classe');
            $table->double('note_de_classe_coefficiente');
            $table->string('note_de_composition');
            $table->string('note_de_composition_coefficiente');
            $table->string('moyenne');
            $table->string('moyenne_coefficiente');
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
