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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('happybday')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('vk')->nullable();
            $table->string('youtube')->nullable();
            $table->string('link')->nullable();
            $table->string('email')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('avatar')->nullable();
            $table->longText('info')->nullable();
            $table->longText('linkvideo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
