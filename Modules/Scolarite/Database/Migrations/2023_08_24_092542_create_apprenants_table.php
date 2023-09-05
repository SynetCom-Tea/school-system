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
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('nom');
            $table->string('prenom');
            $table->string('tel');
            $table->string('mail');
            $table->string('sexe');
            $table->date('dateNaiss');
            $table->string('lieuNaiss');
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('apprenant_classe_annee', function (Blueprint $table) {
            
            $table->foreignIdFor(\Modules\Scolarite\Entities\Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(\Modules\Scolarite\Entities\ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
        });

        DB::statement("ALTER TABLE apprenants ADD COLUMN nom_complet varchar(255)
        GENERATED ALWAYS AS (CONCAT(nom,' ',prenom));");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apprenants');
    }
};
