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
        Schema::create('classe_annees', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Classe::class)
                ->index()
                ->references('id')->on('classes');
            $table->foreignIdFor(\Modules\Scolarite\Entities\AnneeScolaire::class)
                ->index()
                ->references('id')->on('annee_scolaires');
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
        Schema::dropIfExists('classe_annees');
    }
};
