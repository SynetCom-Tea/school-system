<?php

use App\Models\SystemeLmd;
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
        Schema::create('regime_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\GestionNote\Entities\TypeEvaluation::class)->nullable()
            ->index()
            ->references('id')
            ->on('type_evaluations');
            $table->foreignIdFor(SystemeLmd::class)->nullable()
            ->index()
            ->references('id')
            ->on('systeme_lmds');
            $table->double('pourcentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regime_evaluations');
    }
};
