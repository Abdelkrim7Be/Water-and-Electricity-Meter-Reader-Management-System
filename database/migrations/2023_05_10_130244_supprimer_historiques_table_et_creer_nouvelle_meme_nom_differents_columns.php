<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Supprimer la table "historiques" existante
        Schema::dropIfExists('historiques');

        // Créer une nouvelle table "historiques" avec des colonnes différentes
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->integer('releve_plan_id');
            $table->string('acteur');
            $table->string('action_type');
            $table->string('updated_fields');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Supprimer la table "historiques" en cas de rollback
        Schema::dropIfExists('historiques');
    }
};
