<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            // who did it (admin/employee user account)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('type', ['in', 'out', 'transfer', 'broken']);
            $table->integer('qty');

            // optional link to sale id when type = out
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};