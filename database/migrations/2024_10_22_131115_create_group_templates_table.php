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
        Schema::create('group_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_group_id')->constrained('social_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bot_template_id')->nullable()->constrained('bot_templates')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_templates');
    }
};
