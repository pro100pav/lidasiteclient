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
        Schema::create('chat_user_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_user_id')->nullable()->constrained('chat_users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('message_user')->nullable();
            $table->longText('message_bot')->nullable();
            $table->longText('attachment')->nullable();
            $table->longText('type_attach')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_user_messages');
    }
};
