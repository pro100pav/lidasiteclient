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
        Schema::table('bot_templates', function (Blueprint $table) {
            $table->integer('ref_dostigenie')->default(0);
            $table->longText('ref_message')->nullable();
            $table->string('images')->nullable();
            $table->string('video_notice')->nullable();
            $table->string('video')->nullable();
        });
        Schema::table('bot_item_messages', function (Blueprint $table) {
            $table->integer('privat')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bot_templates', function (Blueprint $table) {
            $table->dropColumn("ref_dostigenie");
            $table->dropColumn("images");
            $table->dropColumn("video_notice");
            $table->dropColumn("video");
        });
        Schema::table('bot_item_messages', function (Blueprint $table) {
            $table->dropColumn("privat");
        });
    }
};
