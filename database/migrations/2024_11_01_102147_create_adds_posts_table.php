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
        Schema::create('adds_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bot_id')->nullable()->constrained('bots')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('content')->nullable();
            $table->longText('attachment')->nullable();
            $table->integer('bot')->default(0);
            $table->longText('button')->nullable();
            $table->integer('status')->default(0);
            $table->string('message_ids', 255)->nullable();
            $table->timestamp('sendstart_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adds_posts');
    }
};
