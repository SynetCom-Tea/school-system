<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignant_annees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Enseignement\Entities\Enseignant::class)
                ->index()
                ->references('id')->on('enseignants');
            $table->foreignIdFor(\App\Models\ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
            $table->foreignIdFor(\Modules\Enseignement\Entities\NiveauMatiere::class)
                ->index()
                ->references('id')->on('niveau_matieres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enseignant_annees');
    }
};
