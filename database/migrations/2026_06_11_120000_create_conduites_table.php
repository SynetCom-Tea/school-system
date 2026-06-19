<?php

use App\Models\Apprenant;
use App\Models\ClasseAnnee;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\GestionNote\Entities\Periode;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conduites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apprenant::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ClasseAnnee::class)->constrained('classe_annees')->cascadeOnDelete();
            $table->foreignIdFor(Periode::class)->constrained('periodes')->cascadeOnDelete();
            $table->decimal('note', 4, 2)->default(18.00);
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->unique(['apprenant_id', 'classe_annee_id', 'periode_id'], 'conduites_unique_apprenant_classe_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conduites');
    }
};
