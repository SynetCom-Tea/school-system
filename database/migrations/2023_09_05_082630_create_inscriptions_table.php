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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->date('date_inscription');
            $table->foreignIdFor(\App\Models\Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(\Modules\Enseignement\Entities\CycleFiliere::class)->nullable()
                ->index()
                ->references('id')->on('cycle_filieres');
            $table->foreignIdFor(\App\Models\Annee::class)
                ->index()
                ->references('id')->on('annees');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)->nullable()
                ->index()
                ->references('id')->on('niveauX');
            $table->integer('statut');
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
        Schema::dropIfExists('inscriptions');
    }
};
