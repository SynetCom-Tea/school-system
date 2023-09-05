<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mail');
            $table->string('adresse');
            $table->json('telephone');
            $table->string('ville');
            $table->foreignIdFor(\App\Models\TypeEtablissement::class)->index()
                ->references('id')->on('type_etablissements');
            $table->foreignIdFor(\App\Models\SystemeLmd::class)->nullable()->index()
                ->references('id')->on('systeme_lmds');
            $table->softDeletes();
            $table->timestamps();
        });

<<<<<<< HEAD:database/migrations/2023_09_04_102024_create_etablissements_table.php
        Schema::create('section_etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
=======
        Schema::create('etablissement_section', function (Blueprint $table) {
            
>>>>>>> 390e7a47c809f2dfd9114ff12c9172a63ec3c548:database/migrations/2023_08_23_102036_create_etablissements_table.php
            $table->foreignIdFor(\App\Models\Etablissement::class)
                ->index()
                ->references('id')->on('etablissements');
            $table->foreignIdFor(\App\Models\Section::class)
                ->index()
                ->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etablissements');
    }
};
