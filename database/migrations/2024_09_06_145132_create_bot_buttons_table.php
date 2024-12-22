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
        Schema::create('bot_buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_item_message_id')->nullable()->constrained('bot_item_messages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('text')->nullable();
            $table->string('type_button')->nullable();
            $table->string('callback_button')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_buttons');
    }
};
