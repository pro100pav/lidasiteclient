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
        Schema::create('user_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('balance', 12,2)->default(0);
            $table->decimal('balance_work', 12,2)->default(0);
            $table->decimal('balance_frozen', 12,2)->default(0);
            $table->decimal('all_work', 12,2)->default(0);
            $table->decimal('all_pay', 12,2)->default(0);
            $table->decimal('all_send', 12,2)->default(0);
            $table->decimal('all_accept', 12,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balances');
    }
};
