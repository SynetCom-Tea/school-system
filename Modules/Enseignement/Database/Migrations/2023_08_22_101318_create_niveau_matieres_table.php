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
        Schema::create('niveau_matieres', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('coefficient');
            $table->double('volume_horaire');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->index()
                ->references('id')->on('niveaux');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Matiere::class)
                ->index()
                ->references('id')->on('matieres');
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
        Schema::dropIfExists('niveau_matieres');
    }
};
