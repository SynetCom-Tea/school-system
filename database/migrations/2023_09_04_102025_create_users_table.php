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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('nom')->nullable();
            $table->string('username')->nullable();
            $table->string('prenom')->nullable();
            $table->string('type_user')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignIdFor(\App\Models\Etablissement::class)->nullable()
                ->index()
                ->references('id')->on('etablissements');
            $table->foreignIdFor(\App\Models\Apprenant::class)->nullable()
                ->index()
                ->references('id')->on('apprenants');
            $table->foreignIdFor(\App\Models\User::class)->nullable()
                ->index()
                ->references('id')->on('users');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Enseignant::class)->nullable()
                ->index()
                ->references('id')->on('enseignants');
            $table->foreignIdFor(\Modules\Scolarite\Entities\Tuteur::class)->nullable()
                ->index()
                ->references('id')->on('tuteurs');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_niveaux', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class)
                ->index()
                ->references('id')->on('users');
            $table->foreignIdFor(\Modules\Enseignement\Entities\Niveau::class)
                ->index()
                ->references('id')->on('niveaux');
            $table->foreignIdFor(\App\Models\Annee::class)
                ->index()
                ->references('id')->on('annees');
        });

        

        Schema::create('section_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\EtablissementSection::class)->nullable()
                ->index()
                ->references('id')->on('etablissement_section');
            $table->foreignIdFor(\App\Models\User::class)->nullable()
                ->index()
                ->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
