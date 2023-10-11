<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('nom');
            $table->string('prenom');
            $table->string('sex')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('telephone')->nullable();
            $table->boolean('compte')->nullable();
            $table->foreignIdFor(\App\Models\Etablissement::class)->nullable()
                ->index()
                ->references('id')->on('etablissements');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE enseignants ADD COLUMN NomComplet varchar(255),ADD COLUMN date_lieu_nais varchar(255);");

        DB::unprepared('
            CREATE TRIGGER enseignants_before_insert BEFORE INSERT ON enseignants
            FOR EACH ROW
            BEGIN


                SET NEW.NomComplet = CONCAT(NEW.nom, " ", NEW.prenom);
                SET NEW.date_lieu_nais = CONCAT(NEW.date_naissance, " à ", NEW.lieu_naissance);
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
