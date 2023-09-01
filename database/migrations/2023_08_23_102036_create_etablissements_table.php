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
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('etablissement_section', function (Blueprint $table) {
            
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
