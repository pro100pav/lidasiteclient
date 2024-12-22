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
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type', 255)->nullable();
            $table->string('token', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('link')->nullable();
            $table->integer('webhook')->default(0);
            $table->integer('public')->default(0);
            $table->integer('price_ads')->default(0);
            $table->integer('price_visitka')->default(0);
            $table->integer('price_cepochka')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
