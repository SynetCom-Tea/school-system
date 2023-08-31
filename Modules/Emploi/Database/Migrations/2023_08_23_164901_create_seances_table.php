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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->date('date_seance');
            $table->boolean('statut');
            $table->foreignIdFor(\Modules\Emploi\Entities\Horaire::class)
                ->index()
                ->references('id')->on('horaires');
            $table->foreignIdFor(\App\Models\Salle::class)
                ->index()
                ->references('id')->on('salles');
            $table->foreignIdFor(\Modules\Emploi\Entities\Emploi::class)
                ->index()
                ->references('id')->on('emplois');
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
        Schema::dropIfExists('seances');
    }
};
