<?php

use App\Models\Apprenant;
use App\Models\ClasseAnnee;
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
        Schema::create('apprenant_classe_annees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
            $table->foreignIdFor(Apprenant::class)
                ->index()
                ->references('id')->on('apprenants');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenant_classe_annees');
    }
};
