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
        Schema::create('releve_plan', function (Blueprint $table) {
            $table->id();
            $table->integer('releveur');
            $table->integer('periode');
            $table->integer('acteur');
            $table->integer('version');
            $table->date('date_releve');
            $table->string('num_tournee_debut');
            $table->string('num_tournee_fin');
            $table->json('ordre_lecture');
            $table->integer('nombre_total');
            $table->integer('temps_execution_jours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releve_plans');
    }
};
