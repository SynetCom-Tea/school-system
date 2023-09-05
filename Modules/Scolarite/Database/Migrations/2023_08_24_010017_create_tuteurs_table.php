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
        Schema::create('tuteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('tel')->nullable();
            $table->string('adresse')->nullable();
			$table->string('mail')->nullable();
            $table->timestamps();
        });
		
		Schema::create('apprenant_tuteur', function (Blueprint $table) {
            
            $table->foreignIdFor(\Modules\Scolarite\Entities\Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Tuteur::class)
                ->index()
                ->references('id')->on('tuteurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tuteurs');
    }
};
