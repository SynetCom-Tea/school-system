<?php

use App\Models\Annee;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Scolarite\Entities\TypeFrais;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->double('montant');
            $table->foreignIdFor(TypeFrais::class)
                ->references('id')->on('type_frais')->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignIdFor(\Modules\Enseignement\Entities\CycleFiliere::class)->nullable()
                ->index()
                ->references('id')->on('cycle_filieres');
            $table->foreignIdFor(Annee::class)
                ->references('id')->on('annees')->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignIdFor(Etablissement::class)
                ->references('id')->on('etablissements')->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->references('id')->on('niveaux')->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->softDeletes();
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
        Schema::dropIfExists('frais');
    }
};
