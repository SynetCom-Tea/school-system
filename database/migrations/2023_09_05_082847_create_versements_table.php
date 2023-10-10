<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->date('libelle')->nullable();
            $table->date('date_versement');
            $table->double('montant');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Inscription::class)
                ->index()
                ->references('id')->on('inscriptions');
           
            $table->foreignIdFor(\Modules\Scolarite\Entities\Frais::class)
                ->index()
                ->references('id')->on('frais');
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
        Schema::dropIfExists('versements');
    }
};
