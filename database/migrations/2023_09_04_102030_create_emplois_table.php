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
        Schema::create('emplois', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignIdFor(\App\Models\ClasseAnnee::class)
                ->index()
                ->references('id')->on('classe_annees');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE emplois ADD COLUMN nom_classe varchar(255);");

        DB::statement("
            CREATE TRIGGER update_emploi_info
            BEFORE INSERT ON emplois
            FOR EACH ROW
            BEGIN

                SET @classe_id = (SELECT classe_id FROM classe_annees WHERE id = NEW.classe_annee_id);

                SET NEW.nom_classe = (SELECT libelle FROM classes WHERE id = @classe_id);
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
        Schema::dropIfExists('emplois');
    }
};
