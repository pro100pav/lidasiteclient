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
        Schema::create('bot_item_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_message_id')->nullable()->constrained('bot_messages')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('message')->nullable();
            $table->string('images')->nullable();
            $table->string('video')->nullable();
            $table->integer('type_button')->nullable();
            $table->string('function', 255)->nullable();
            $table->integer('fixed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_item_messages');
    }
};
