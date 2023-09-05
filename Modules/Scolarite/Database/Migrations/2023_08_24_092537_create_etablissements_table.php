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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mail');
            $table->string('adresse');
            $table->json('telephone');
            $table->string('ville');
            $table->foreignIdFor(\Modules\Scolarite\Entities\TypeEtablissement::class)->index()
                ->references('id')->on('type_etablissements');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('etablissement_section', function (Blueprint $table) {
            
            $table->foreignIdFor(\Modules\Scolarite\Entities\Etablissement::class)
                ->index()
                ->references('id')->on('etablissements');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Section::class)
                ->index()
                ->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etablissements');
    }
};
