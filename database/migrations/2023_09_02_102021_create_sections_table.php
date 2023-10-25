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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('role_sections', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\section::class)
                ->index()
                ->references('id')->on('sections');
            $table->foreignIdFor(\App\Models\Role::class)
                ->index()
                ->references('id')->on('roles');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
