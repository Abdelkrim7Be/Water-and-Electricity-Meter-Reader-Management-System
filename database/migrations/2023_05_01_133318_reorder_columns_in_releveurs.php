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
        Schema::table('releveurs', function (Blueprint $table) {
            //
            $table->dropColumn('iconImage');
        });
        Schema::table('releveurs', function (Blueprint $table) {
            //
            $table->string('iconImage')->after('serialNumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('releveurs', function (Blueprint $table) {
            //
            $table->dropColumn('iconImage');
        });
    }
};
