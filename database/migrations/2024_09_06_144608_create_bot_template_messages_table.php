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
        Schema::create('bot_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_template_id')->nullable()->constrained('bot_templates')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 255)->nullable();
            $table->string('trigger')->nullable();
            $table->string('id_message')->nullable();
            $table->integer('privat')->default(0);
            $table->longText('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_messages');
    }
};
