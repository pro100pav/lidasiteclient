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
        Schema::create('social_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_id')->nullable()->constrained('bots')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('id_group')->nullable();
            $table->string('group_name')->nullable();
            $table->string('username')->nullable();
            $table->integer('type')->default(1);
            $table->string('role')->nullable();
            $table->integer('status')->default(1);
            $table->string('link', 255)->nullable();
            $table->integer('podpiska')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_groups');
    }
};
