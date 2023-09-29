<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->date('date_seance')->nullable();
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->boolean('statut');
            $table->foreignIdFor(\Modules\Emploi\Entities\Horaire::class)
                ->index()
                ->references('id')->on('horaires');
            $table->foreignIdFor(\App\Models\Salle::class)->nullable()
                ->index()
                ->references('id')->on('salles');
            $table->foreignIdFor(\Modules\Enseignement\Entities\NiveauMatiere::class)
                ->index()
                ->references('id')->on('niveau_matieres');
            $table->foreignIdFor(\Modules\Emploi\Entities\Emploi::class)
                ->index()
                ->references('id')->on('emplois');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE seances ADD COLUMN libelle_niveau varchar(255);");
        DB::statement("ALTER TABLE seances ADD COLUMN nom_matiere varchar(255);");

        DB::statement("
            CREATE TRIGGER update_seance_info
            BEFORE INSERT ON seances
            FOR EACH ROW
            BEGIN
                SET @niveau_id = (SELECT niveau_id FROM niveau_matieres WHERE id = NEW.niveau_matiere_id);

                SET @matiere_id = (SELECT matiere_id FROM niveau_matieres WHERE id = NEW.niveau_matiere_id);

                SET NEW.nom_matiere = (SELECT nom FROM matieres WHERE id = @matiere_id);
            
                SET NEW.libelle_niveau = (SELECT libelle FROM niveaux WHERE id = @niveau_id);
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
};
