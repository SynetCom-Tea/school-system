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
        Schema::create('fillieres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Cycle::class)->index()
                ->references('id')->on('cycles');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('etablissement_fillieres', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignIdFor(\App\Models\Etablissement::class)
                ->index()
                ->references('id')->on('etablissements');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Filliere::class)
                ->index()
                ->references('id')->on('fillieres');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fillieres');
        Schema::dropIfExists('filliere_etablissement');
    }
};
