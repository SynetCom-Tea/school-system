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
        Schema::dropIfExists('notes');
    }
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->double('note')->nullable();
            $table->foreignIdFor(\App\Models\Apprenant::class)->nullable()
                ->index()
                ->references('id')
                ->on('apprenants');
            $table->foreignIdFor(\Modules\GestionNote\Entities\Evaluation::class)->nullable()
            ->index()
            ->references('id')
            ->on('evaluations');
            $table->integer('statut')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */

};
