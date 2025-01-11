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
        Schema::table('update_sistems', function (Blueprint $table) {
            $table->integer('new_update')->default(0);
            $table->string('version')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('update_sistems', function (Blueprint $table) {
            $table->dropColumn("new_update");
            $table->dropColumn("version");
            $table->dropColumn("type");
        });
    }
};
