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
        Schema::create('anneeClasses', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->foreignIdFor(\Modules\Scolarite\Entities\Annee::class)
                ->references('id')->on('annees')->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Classe::class)
                ->references('id')->on('classes')->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
        Schema::dropIfExists('anneeClasses');
    }
};
