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
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('nom_complete')->nullable();
            $table->string('date_nais')->nullable();
            // $table->foreignIdFor(App\Models\CursusPreBac::class)->nullable()
            //     ->index()
            //     ->references('id')
            //     ->on('cursus_pre_bacs');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    
};
