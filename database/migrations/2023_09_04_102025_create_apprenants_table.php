<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenants');
    }
    public function up(): void
    {
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('sex')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('telephone')->nullable();
            $table->foreignIdFor(\App\Models\Etablissement::class)->nullable()
                ->index()
                ->references('id')->on('etablissements');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('apprenant_tuteur', function (Blueprint $table) {

            $table->foreignIdFor(\App\Models\Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Tuteur::class)
                ->index()
                ->references('id')->on('tuteurs');
        });
    }

    /**
     * Reverse the migrations.
     */

};
